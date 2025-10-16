<?php

namespace App\Http\Controllers\Articulos;

use Illuminate\Http\Request;
use App\Http\Requests\Articulos\ObtenerArticulosRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PrecioController;
use App\Services\Cliente\ClienteService;
use App\Services\Parametros\ParametrosService;
use App\Services\Articulo\ArticuloService;
use App\Helper\ApiResponse;

class ArticulosObtenerArticulosController extends Controller
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

    public function obtenerArticulos(ObtenerArticulosRequest $request)
    {
        try {
            $params = $request->obtenerParametros();
            $paginacion = $request->obtenerPaginacion();
            $art_precio = $request->obtenerPrecioCliente();
            $order_by = $request->obtenerOrdenamiento($params);
            $hostIMG = $this->determinarHostIMG($request->getHost());
            $palabrasProcesadas = $this->procesarBusqueda($params->busqueda);
            $busquedas = !empty($palabrasProcesadas) ? $this->generarBusqueda($palabrasProcesadas) : [];

            $query = $this->formarQuery($params);
            $precioObtenido = $this->obtenerPrecio($params);
            $tipoBusqueda = [1, 2, 3, 4];

            $articulos = collect();
            $cantidadArticulos = [];

            foreach ($tipoBusqueda as $tipo) {
                $cantidadArticulos = $this->articuloService->contarArticulos($query, $params, $busquedas, $tipo);

                $articulos = collect(
                    $this->articuloService->obtenerArticulos(
                        $hostIMG,
                        $art_precio,
                        $precioObtenido,
                        $order_by,
                        $params,
                        $query,
                        $busquedas,
                        $paginacion,
                        $tipo
                    )
                );

                if ($articulos->isNotEmpty() && ($cantidadArticulos[0]->total ?? 0) > 0) {
                    break;
                }
            }

            $porcentajes = $this->clienteService->calcularPorcentajeCliente($params->clicod);
            $condVenta = $this->parametroService->obtenerCondVenta();

            if ($params->banderaVendedor == 0 && $condVenta && $condVenta->CondVenta == 1) {
                $articulos = $this->calcularPrecio($params->clicod, $articulos, $porcentajes);
            } else {
                $articulos->each(function ($articulo) {
                    $articulo->precioInicial = $articulo->precio;
                    $articulo->precio = $this->calcularPrecioConDescuentos($articulo);
                });
            }

            return response()->json([
                'total' => $cantidadArticulos[0]->total ?? 0,
                'articulos' => $articulos
            ]);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
    
    private function determinarHostIMG(string $host): string
    {
        return in_array($host, ['localhost', '10.15.20.203'])
            ? 'https://10.15.20.201:70/'
            : 'https://imgcoronel.dyndns.org:70/';
    }

    private function procesarBusqueda(?string $busqueda): object
    {
        $resultado = new \stdClass();

        if (!empty($busqueda)) {
            $busqueda = trim($busqueda);
            $palabras = explode(' ', strtoupper($busqueda));
            $resultado->palabrasBuscar = implode(' ', $palabras);
            $resultado->substring = substr($palabras[0], 0, 3) ?? '';
            $resultado->PrimerPalabra = $palabras[0] ?? '';
            $resultado->SegundaPalabra = $palabras[1] ?? '';
        }

        return $resultado;
    }

    private function formarQuery(\stdClass $params)
    {
        $queryConditions = new \stdClass();
        $queryConditions->tipoProducto = $this->crearCondicion($params->tipoProducto, 'art_tipprod');
        $queryConditions->rubro = $this->crearCondicion($params->rubro, 'art_rubro');
        $queryConditions->linea = $this->crearCondicion($params->linea, 'art_linea');
        $queryConditions->fabrica = $this->crearCondicion($params->fabrica, 'art_codtex');
        $queryConditions->codbarra = $this->crearCondicionCompuesta($params->codbarra, 'art_codbarra', 'ada_codbarra');
        $queryConditions->codfab = $this->crearCondicion($params->codfab, 'art_codfab');
        $queryConditions->codinterno = $this->crearCondicion(strtoupper($params->codinterno), 'art_codinterno');

        return $queryConditions;
    }

    private function crearCondicion($valor, $campo)
    {
        return !empty($valor) ? " AND $campo='" . $valor . "'" : '';
    }

    private function crearCondicionCompuesta($valor, $campo1, $campo2)
    {
        return !empty($valor) ? " AND ($campo1='" . $valor . "' OR $campo2='" . $valor . "')" : '';
    }

    private function generarBusqueda($palabrasProcesadas)
    {
        $resultado = new \stdClass();

        if (!empty($palabrasProcesadas->palabrasBuscar)) {
            $resultado->Q = " AND (art_descriWeb LIKE '%$palabrasProcesadas->palabrasBuscar%' OR art_codnum LIKE '%$palabrasProcesadas->palabrasBuscar%')";
        } else {
            $resultado->Q = "";
        }

        if (!empty($palabrasProcesadas->palabrasBuscar)) {
            $resultado->Q_busqueda = "WHERE subquery_externa.concatenado COLLATE Latin1_General_CI_AI LIKE '%" . $palabrasProcesadas->palabrasBuscar . "%'";

            $condicionesExtra = "(
                ISNULL(art_linea, '') + ' ' + ISNULL(fab_descri, '') + ' ' + 
                ISNULL(rlf_lindescri, '') + ' ' + ISNULL(rub_descri, '') + ' ' +
                ISNULL(tpp_descri, '') + ' ' + ISNULL(art_descriWeb, '') + ' ' +
                ISNULL(art_descriabrev, '') + ' ' + ISNULL(adi_descri, '') + ' ' +
                ISNULL(art_codbarra, '') + ' ' + ISNULL(art_codtex, '') +
                CAST(ISNULL(art_codnum, '') AS VARCHAR(50)) + ' ' + 
                ISNULL(art_descri, '')
            ) LIKE '%" . $palabrasProcesadas->palabrasBuscar . "%'";

            $resultado->Q_extra = " AND (" . $condicionesExtra . ")";
        } else {
            $resultado->Q_busqueda = "";
            $resultado->Q_extra = "";
        }

        if (!empty($palabrasProcesadas->PrimerPalabra)) {
            $resultado->Q_busquedaPalabras = "WHERE subquery_externa.concatenado COLLATE Latin1_General_CI_AI LIKE '%" . $palabrasProcesadas->PrimerPalabra . "%'";

            if (!empty($palabrasProcesadas->SegundaPalabra)) {
                $resultado->Q_busquedaPalabras .= " AND subquery_externa.concatenado COLLATE Latin1_General_CI_AI LIKE '%" . $palabrasProcesadas->SegundaPalabra . "%'";
            }

            $condicionesPrimerPalabra = "(
                ISNULL(art_linea, '') + ' ' + ISNULL(fab_descri, '') + ' ' + 
                ISNULL(rlf_lindescri, '') + ' ' + ISNULL(rub_descri, '') + ' ' +
                ISNULL(tpp_descri, '') + ' ' + ISNULL(art_descriWeb, '') + ' ' +
                ISNULL(art_descriabrev, '') + ' ' + ISNULL(adi_descri, '') + ' ' +
                ISNULL(art_codbarra, '') + ' ' + ISNULL(art_codtex, '') +
                CAST(ISNULL(art_codnum, '') AS VARCHAR(50)) + ' ' + 
                ISNULL(art_descri, '')
            ) LIKE '%" . $palabrasProcesadas->PrimerPalabra . "%'";

            $condicionesSegundaPalabra = !empty($palabrasProcesadas->SegundaPalabra) ? " AND (
                ISNULL(art_linea, '') + ' ' + ISNULL(fab_descri, '') + ' ' + 
                ISNULL(rlf_lindescri, '') + ' ' + ISNULL(rub_descri, '') + ' ' +
                ISNULL(tpp_descri, '') + ' ' + ISNULL(art_descriWeb, '') + ' ' +
                ISNULL(art_descriabrev, '') + ' ' + ISNULL(adi_descri, '') + ' ' +
                ISNULL(art_codbarra, '') + ' ' + ISNULL(art_codtex, '') +
                CAST(ISNULL(art_codnum, '') AS VARCHAR(50)) + ' ' + 
                ISNULL(art_descri, '')
            ) LIKE '%" . $palabrasProcesadas->SegundaPalabra . "%'" : '';

            $resultado->Q_extraPalabras = " AND (" . $condicionesPrimerPalabra . $condicionesSegundaPalabra . ")";
        } else {
            $resultado->Q_busquedaPalabras = "";
            $resultado->Q_extraPalabras = "";
        }

        if (!empty($palabrasProcesadas->substring)) {
            $resultado->Q_busquedaSubstring = "WHERE subquery_externa.concatenado COLLATE Latin1_General_CI_AI LIKE '%" . $palabrasProcesadas->substring . "%'";

            $condicionesExtra = "(
                ISNULL(art_linea, '') + ' ' + ISNULL(fab_descri, '') + ' ' + 
                ISNULL(rlf_lindescri, '') + ' ' + ISNULL(rub_descri, '') + ' ' +
                ISNULL(tpp_descri, '') + ' ' + ISNULL(art_descriWeb, '') + ' ' +
                ISNULL(art_descriabrev, '') + ' ' + ISNULL(adi_descri, '') + ' ' +
                ISNULL(art_codbarra, '') + ' ' + ISNULL(art_codtex, '') + ' ' + 
                CAST(ISNULL(art_codnum, '') AS VARCHAR(50)) + ' ' + 
                ISNULL(art_descri, '')
            ) LIKE '%" . $palabrasProcesadas->substring . "%'";

            $resultado->Q_extraSubstring = " AND (" . $condicionesExtra . ")";
        } else {
            $resultado->Q_busquedaSubstring = "";
            $resultado->Q_extraSubstring = "";
        }

        return $resultado;
    }

    private function obtenerPrecio(\stdClass $params)
    {
        return ($params->banderaVendedor == 0)
            ? $this->clienteService->buscarCategoria($params->clicod)
            : "art_precmayo AS precio";
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
                    'art_tipodescri' => $articulo->art_tipodescri ?? null,
                    'art_rubdescri' => $articulo->art_rubdescri ?? null,
                    'art_lindescri' => $articulo->art_lindescri ?? null,
                    'art_fabdescri' => $articulo->art_fabdescri ?? null,
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
