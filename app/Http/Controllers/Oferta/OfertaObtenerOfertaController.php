<?php

namespace App\Http\Controllers\Novedad;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PrecioController;
use Illuminate\Http\Request;
use App\Http\Requests\Oferta\ObtenerOfertasRequest;
use App\Services\Oferta\OfertaService;
use App\Services\Cliente\ClienteService;
use App\Services\Parametros\ParametrosService;
use App\Helper\ApiResponse;

class OfertaObtenerOfertaController extends Controller
{
    protected $parametroService;
    protected $clienteService;
    protected $ofertaService;
    protected $apiResponse;

    public function __construct(
        ParametrosService $parametroService,
        ClienteService $clienteService,
        OfertaService $ofertaService,
        ApiResponse $apiResponse
    ) {
        $this->parametroService = $parametroService;
        $this->clienteService = $clienteService;
        $this->ofertaService = $ofertaService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerOfertas(ObtenerOfertasRequest $request)
    {
        try {
            $hostIMG = $this->determinarHostIMG($request->getHost());
            $datosObtenidos = $request->obtenerParametrosOferta();
            $categorias = [
                1 => "ofe_categoria = '1'",
                2 => "ofe_categoria = '2'",
                3 => "ofe_categoria = '3'",
                4 => "ofe_categoria = '4'"
            ];
            $CAT = $categorias[$datosObtenidos->ofeCategoria] ?? '';
            $art_precio = $datosObtenidos->banderaVendedor == 0 && $datosObtenidos->catTipo == 1 ? "Articulo.art_precmino as precioInicial" : "Articulo.art_precmayo as precioInicial";
            $order_by = "ORDER BY ofe_artdescri ASC ";
            $max = $datosObtenidos->page * $datosObtenidos->limit;
            $min = (($datosObtenidos->page - 1) * $datosObtenidos->limit) + 1;
            $cantidadOfertas = $this->ofertaService->contarOfertas($datosObtenidos->OfeDesde, $datosObtenidos->OfeHasta, $CAT, $datosObtenidos->tipProd);
            $ofertas = collect($this->ofertaService->obtenerOfertas($order_by, $datosObtenidos->tipProd, $art_precio, $hostIMG, $CAT, $min, $max));
            $porcentajes = $this->clienteService->calcularPorcentajeCliente($datosObtenidos->clicod);

            if ($datosObtenidos->banderaVendedor == 0) {
                $condVenta = $this->parametroService->obtenerCondVenta();
                $condVentaValue = $condVenta ? $condVenta->CondVenta : 0;
                if ($condVentaValue == 1 && $porcentajes != 0) {
                    $ofertas = $this->calculoOferta($datosObtenidos->clicod, $ofertas, $porcentajes);
                } else {
                    $ofertas = $ofertas->map(function ($oferta) {
                        return $this->aplicarDescuentos($oferta);
                    });
                }
            } else {
                $ofertas = $ofertas->map(function ($oferta) {
                    return $this->aplicarDescuentos($oferta);
                });
            }

            return response()->json([
                'total' => $cantidadOfertas,
                'ofertas' => $ofertas
            ]);
        } catch (\Exception $e) {
            return $this->apiResponse->serverError($e, "Ocurrió un error al procesar la solicitud.");

        }
    }

    private function determinarHostIMG($host)
    {
        $ipsLocales = ["localhost", "192.168.0.200"];
        return in_array($host, $ipsLocales)
            ? "http://192.168.0.201:70/"
            : "https://imgcoronel.dyndns.org:70/";
    }

    private function aplicarDescuentos($oferta)
    {
        $precio = $oferta->precioInicial;
        for ($i = 1; $i <= 6; $i++) {
            $descuento = "ofe_dto$i";
            $precio *= (1 + ($oferta->$descuento / 100));
        }
        $oferta->precio = $precio;
        return $oferta;
    }

    private function calculoOferta($clicod, $articulos, $porcentajes)
    {
        $precioXArti = [];
        $precioController = app(PrecioController::class);

        foreach ($articulos as $articulo) {
            $sinBarra   = str_replace("/", "-", $articulo->ofe_adicod);
            $sinEspacio = str_replace(" ", "%20", $sinBarra);
            $datosObtenidos = [
                'CODTEX'  => $articulo->ofe_codtex,
                'CODNUM'  => $articulo->ofe_codnum,
                'ADICOD'  => $sinEspacio,
                'CANT'    => 1,
                'CLICOD'  => $clicod,
                'Bandera' => 'false',
                'FPAGO'   => '',
                'CVTA'    => ''
            ];

            $request = Request::create('/precio', 'GET', $datosObtenidos);

            try {
                $response = $precioController->obtenerPrecio($request);
                $descuento = $response->getData(true);

                $descuento['precioInicial'] = $descuento['precioLista'] * (1 + ($porcentajes / 100));
                $precioCalculado = $descuento['precioInicial']  * (1 + (floatval($descuento['des1']) / 100));
                for ($i = 1; $i <= 6; $i++) {
                    $precioCalculado *= (1 + (floatval($descuento["des{$i}"]) / 100));
                }
                $descuento['precio'] = $precioCalculado;

                if (!is_null($descuento['precio'])) {
                    $nuevoArticulo = $this->construirArticulo($articulo, [
                        "ofe_preciolista" => $descuento['precioLista'],
                        "precioInicial"   => $descuento['precioInicial'],
                        "precio"          => round($descuento['precio'], 2),
                        "iva"             => $descuento['iva'],
                        "des1"            => $descuento['des1'] == "0" ? "" : (float)$descuento['des1'],
                        "des2"            => $descuento['des2'] == "0" ? "" : (float)$descuento['des2'],
                        "des3"            => $descuento['des3'] == "0" ? "" : (float)$descuento['des3'],
                        "des4"            => $descuento['des4'] == "0" ? "" : (float)$descuento['des4'],
                        "des5"            => $descuento['des5'] == "0" ? "" : (float)$descuento['des5'],
                        "des6"            => $descuento['des6'] == "0" ? "" : (float)$descuento['des6'],
                        "desa"            => $descuento['desa'],
                        "desc"            => $descuento['desc'],
                        "desd"            => $descuento['desd'],
                        "descto"          => $descuento['descto'],
                    ]);
                } else {
                    $pre_fin = $articulo->ofe_preclista;
                    for ($i = 1; $i <= 6; $i++) {
                        $pre_fin *= (1 + (floatval($descuento["des{$i}"]) / 100));
                    }
                    $pre_fin *= (1 + ($porcentajes / 100));
                    $nuevoArticulo = $this->construirArticulo($articulo, [
                        "ofe_preciolista" => $articulo->ofe_preclista ?? null,
                        "precio"          => round($pre_fin, 2)
                    ]);
                }
                $precioXArti[] = $nuevoArticulo;
            } catch (\Exception $e) {
                echo '{"error": {"text": "' . $e->getMessage() . '"}}';
                continue;
            }
        }
        return $precioXArti;
    }

    private function construirArticulo($articulo, array $extras = [])
    {
        return array_merge([
            "ofe_codtex"       => $articulo->ofe_codtex,
            "ofe_artdescri"    => $articulo->ofe_artdescri,
            "ofe_codnum"       => $articulo->ofe_codnum,
            "ofe_adicod"       => $articulo->ofe_adicod,
            "ofe_adidescri"    => $articulo->ofe_adidescri,
            "ofe_codbarra"     => $articulo->ofe_codbarra,
            "ofe_fotoArticulo" => $articulo->ofe_fotoArticulo,
            "ofe_cantidad"     => $articulo->ofe_cantidad,
            "Seq"              => $articulo->Seq ?? null,
            "ofe_dto1"         => $articulo->ofe_dto1,
            "ofe_dto2"         => $articulo->ofe_dto2,
            "ofe_dto3"         => $articulo->ofe_dto3,
            "ofe_dto4"         => $articulo->ofe_dto4,
            "ofe_dto5"         => $articulo->ofe_dto5,
            "ofe_dto6"         => $articulo->ofe_dto6,
            "ofe_desde"        => $articulo->ofe_desde,
            "ofe_hasta"        => $articulo->ofe_hasta,
            "ofe_minimo"       => $articulo->ofe_minimo,
            "ofe_AplicaWEB"    => $articulo->ofe_AplicaWEB ?? null,
        ], $extras);
    }
}