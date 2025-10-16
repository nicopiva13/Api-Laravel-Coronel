<?php

namespace App\Http\Controllers\Articulo;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PrecioController;
use Illuminate\Http\Request;
use App\Services\Cliente\ClienteService;
use App\Services\Parametros\ParametrosService;
use App\Services\Articulo\ArticuloService;
use App\Helper\ApiResponse;

class ArticuloObtenerArticuloController extends Controller
{
    protected $parametroService;
    protected $clienteService;
    protected $articuloService;
    protected $apiResponse;

    public function __construct(
        ParametrosService $parametroService,
        ClienteService $clienteService,
        ArticuloService $articuloService,
        ApiResponse $apiResponse
    ) {
        $this->parametroService = $parametroService;
        $this->clienteService = $clienteService;
        $this->articuloService = $articuloService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerArticulo($fabrica, $codigo, $clicod, $BanderaVen, $cli_categoria)
    {
        try {
            $hostIMG = $this->determinarHost();

            if ($fabrica == "0") {
                $fabrica = "";
                $COND = "AND art_codnum = '$codigo'";
            } else {
                $COND = "AND art_codtex = '$fabrica' AND art_codnum = '$codigo'";
            }

            $total = $this->articuloService->contarArticulo($COND);
            $total = $total[0]->total ?? 0;

            if ($total === 0) {
                return $this->apiResponse->notFound('No se encontraron artículos.');
            }

            $articulo = collect($this->articuloService->obtenerArticulo($hostIMG, $this->obtenerPrecio($BanderaVen, $clicod), $cli_categoria, $COND));
            $porcentajes = $this->clienteService->calcularPorcentajeCliente($clicod);
            $condVenta = $this->parametroService->obtenerCondVenta();

            if ($BanderaVen == 0 && $condVenta && $condVenta->CondVenta == 1) {
                $articuloCalculado = $this->calcularPrecio($clicod, $articulo, $porcentajes);
                $articulo = $articuloCalculado;
            } else {
                $articulo->each(function ($articulo) {
                    $articulo->precioInicial = $articulo->precio;
                    $articulo->precio = $this->calcularPrecioConDescuentos($articulo);
                });
            }

            return response()->json([
                'total' => (int) $total,
                'articulos' => $articulo
            ]);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }

    private function determinarHost()
    {
        $hostIMG = request()->getHost();
        return in_array($hostIMG, ["localhost", "10.15.20.203"])
            ? "http://10.15.20.201:70/"
            : "https://imgcoronel.dyndns.org:70/";
    }

    private function obtenerPrecio($BanderaVen, $clicod)
    {
        if ($BanderaVen == 0) {
            return $this->clienteService->buscarCategoria($clicod);
        }

        return "art_precmayo AS precio";
    }

    private function calcularPrecioConDescuentos($articulo)
    {
        $precio = $articulo->precio;
        $descuentos = [
            'ofe_dto1',
            'ofe_dto2',
            'ofe_dto3',
            'ofe_dto4',
            'ofe_dto5',
            'ofe_dto6'
        ];

        foreach ($descuentos as $descuento) {
            $precio *= (1 + ($articulo->$descuento / 100));
        }

        return $precio;
    }

    private function calcularPrecio($clicod, $articulos, $porcentajes)
    {
        $precioXArti = [];
        $precioController = app(PrecioController::class);
        $descuentoKeys = ['des1', 'des2', 'des3', 'des4', 'des5', 'des6'];

        foreach ($articulos as $articulo) {
            $sinEspacio = str_replace(["/", " "], ["-", "%20"], $articulo->adi_codigo);

            $datosObtenidos = [
                'CODTEX'  => $articulo->art_codtex,
                'CODNUM'  => $articulo->art_codnum,
                'ADICOD'  => $sinEspacio,
                'CANT'    => 1,
                'CLICOD'  => $clicod,
                'Bandera' => 'false',
                'FPAGO'   => '',
                'CVTA'    => ''
            ];

            try {
                $request = Request::create('/precio', 'GET', $datosObtenidos);
                $response = $precioController->obtenerPrecio($request);
                $descuento = $response->getData(true) ?? [];
                $descuento['precioInicial'] = $descuento['precioLista'] * (1 + ($porcentajes / 100));
                $precioCalculado = $descuento['precioInicial'];

                foreach ($descuentoKeys as $key) {
                    $valorDescuento = isset($descuento[$key]) ? floatval($descuento[$key]) : 0;
                    $precioCalculado *= (1 + ($valorDescuento / 100));
                }

                $descuento['precio'] = round($precioCalculado, 2);
                $descuentoTotales = [];
                foreach ($descuento as $key => $value) {
                    if (preg_match('/^des[1-6]$/', $key)) {
                        $descuentoTotales[$key] = floatval($value);
                    }
                }
                $totalDescuentos = array_sum($descuentoTotales);
                $ofe_aplicaWeb = $totalDescuentos < 0 ? 1 : 0;

                $nuevoArticulo = [
                    "art_codtex" => $articulo->art_codtex,
                    "art_codnum" => $articulo->art_codnum,
                    "adi_codigo" => $articulo->adi_codigo,
                    "adi_descri" => $articulo->adi_descri,
                    "art_CtrlMino" => $articulo->art_CtrlMino,
                    "art_CtrlMayo" => $articulo->art_CtrlMayo,
                    "art_descri" => $articulo->art_descri,
                    "art_codbarra" => $articulo->art_codbarra,
                    "embalaje" => $articulo->embalaje,
                    "fotoArticulo" => $articulo->fotoArticulo,
                    "art_tipprod" => $articulo->art_tipprod,
                    "art_rubro" => $articulo->art_rubro,
                    "art_linea" => $articulo->art_linea,
                    "art_tipodescri" => $articulo->art_tipodescri,
                    "art_rubdescri" => $articulo->art_rubdescri,
                    "art_lindescri" => $articulo->art_lindescri,
                    "art_fabdescri" => $articulo->art_fabdescri,
                    "cantidad" => $articulo->cantidad,
                    "Seq" => $articulo->Seq ?? null,
                    "ofe_AplicaWEB" => $ofe_aplicaWeb,
                ];

                foreach ($descuentoKeys as $index => $key) {
                    $nuevoArticulo["ofe_dto" . ($index + 1)] = $descuento[$key] ?? ($articulo->{"ofe_dto" . ($index + 1)} ?? 0);
                    $nuevoArticulo["des" . ($index + 1)] = !empty($descuento[$key]) && $descuento[$key] != "0" ? (float) $descuento[$key] : "";
                }

                if ($descuento['precio'] !== null) {
                    $nuevoArticulo += [
                        "art_preclista" => $descuento['precioLista'],
                        "precioInicial" => $descuento['precioInicial'],
                        "precio" => $descuento['precio'],
                        "iva" => $descuento['iva'],
                        "desa" => $descuento['desa'],
                        "desc" => $descuento['desc'],
                        "desd" => $descuento['desd'],
                        "descto" => $descuento['descto'],
                        "descuentoUsuario" => $descuento['ofertasUsuario']
                    ];
                } else {
                    $nuevoArticulo["precio"] = round($articulo->precio, 2);
                }
                $precioXArti[] = $nuevoArticulo;
            } catch (\Exception $e) {
            }
        }

        return $precioXArti;
    }
}