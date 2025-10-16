<?php

namespace App\Http\Controllers\Novedad;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PrecioController;
use App\Http\Requests\Novedad\ObtenerNovedadesRequest;
use Illuminate\Http\Request;
use App\Services\Parametros\ParametrosService;
use App\Services\Cliente\ClienteService;
use App\Services\Novedad\NovedadService;
use App\Helper\ApiResponse;

class NovedadObtenerNovedadesController extends Controller
{
    protected $parametrosService;
    protected $clienteService;
    protected $novedadService;
    protected $apiResponse;

    public function __construct(
        ParametrosService $parametrosService,
        ClienteService $clienteService,
        NovedadService $novedadService,
        ApiResponse $apiResponse
    ) {
        $this->parametrosService = $parametrosService;
        $this->clienteService = $clienteService;
        $this->novedadService = $novedadService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerNovedades(ObtenerNovedadesRequest $request)
    {
        $hostIMG = $this->determinarHost();
        $cli_categoria     = $request->cliCategoria();
        $clicod            = $request->cliCod();
        $banderaVendedor   = $request->banderaVendedor();
        $orden             = $request->orden();
        $precio            = $request->precio();
        $precioMin         = $request->precioMin();
        $precioMax         = $request->precioMax();
        $tipoCliente       = $request->tipoCliente();
        $page              = $request->pagina();
        $limit             = $request->cantidad();
        $tipProd           = $request->tipoProducto();
        $condicionTipoProd = $this->generarCondicionTipoProd($tipProd);
        $art_precio = $this->obtenerColumnaPrecioPorTipoCliente($tipoCliente);
        $order_by = $this->generarOrderBy($orden, $precio);
        ['min' => $min, 'max' => $max] = $this->calcularRangoPaginacion($page, $limit);
        try {
            $cantidadNovedad = $this->novedadService->cantidadNovedad($condicionTipoProd);
            $precioObtenido = $this->obtenerPrecio($banderaVendedor, $clicod);
            $novedades = collect($this->novedadService->obtenerNovedades($hostIMG, $precioObtenido, $art_precio, $order_by, $cli_categoria, $condicionTipoProd, $precioMax, $precioMin, $min, $max));
            $porcentajes = $this->clienteService->calcularPorcentajeCliente($clicod);
            $condVenta = $this->parametrosService->obtenerCondVenta();
            if ($banderaVendedor == 0 && $condVenta && $condVenta->CondVenta == 1) {
                $novedadesCalculadas = $this->calcularPrecio($clicod, $novedades, $porcentajes);
                $novedades = $novedadesCalculadas;
            } else {
                $novedades->each(function ($novedades) {
                    $novedades->precioInicial = $novedades->precio;
                    $novedades->precio = $this->calcularPrecioConDescuentos($novedades);
                });
                $novedades = $novedades;
            }
            
            return response()->json([
                'cantidad' => $cantidadNovedad,
                'novedades' => $novedades
            ], 200);

        } catch (\Throwable  $e) {
            return $this->apiResponse->serverError($e, 'Error al obtener las novedades.');
        }
    }

    private function determinarHost()
    {
        $hostIMG = request()->getHost();
        return in_array($hostIMG, ['localhost', '10.15.20.203'])
            ? 'http://10.15.20.201:70/'
            : 'https://imgcoronel.dyndns.org:70/';
    }

    private function generarCondicionTipoProd($tipProd)
    {
        return $tipProd ? " AND art_tipprod = '" . addslashes($tipProd) . "' " : '';
    }

    private function obtenerColumnaPrecioPorTipoCliente($tipoCliente)
    {
        $mapTipoCliente = [
            1 => 'art_precmino AS art_preclista',
            2 => 'art_precmayo AS art_preclista'
        ];

        $tipoCliente = in_array($tipoCliente, array_keys($mapTipoCliente)) ? $tipoCliente : 2;

        return $mapTipoCliente[$tipoCliente];
    }

    private function generarOrderBy($orden, $precio)
    {
        $ordenValido = in_array(strtoupper($orden), ['ASC', 'DESC']);
        $precioValido = in_array(strtoupper($precio), ['ASC', 'DESC']);

        if ($orden && !$precio && $ordenValido) {
            return "ORDER BY art_descri " . strtoupper($orden);
        }

        if (!$orden && $precio && $precioValido) {
            return "ORDER BY art_preclista " . strtoupper($precio);
        }

        return "ORDER BY art_descri ASC";
    }

    private function calcularRangoPaginacion(int $page, int $limit): array
    {
        $min = (($page - 1) * $limit) + 1;
        $max = $page * $limit;

        return ['min' => $min, 'max' => $max];
    }

    private function obtenerPrecio($BanderaVen, $clicod)
    {
        if ($BanderaVen == 0) {
            return $this->clienteService->buscarCategoria($clicod);
        }

        return "art_precmayo AS precio";
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
                    // "art_tipodescri" => $articulo->art_tipodescri,
                    // "art_rubdescri" => $articulo->art_rubdescri,
                    // "art_lindescri" => $articulo->art_lindescri,
                    // "art_fabdescri" => $articulo->art_fabdescri,
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
                return response()->json(['error' => ['text' => $e->getMessage()]], 500);
            }
        }
        return $precioXArti;
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
}