<?php

namespace App\Http\Controllers;

use App\Http\Requests\Precio\ObtenerPrecioRequest;
use App\Services\Parametros\ParametrosService;
use App\Services\TipCta\TipCtaService;
use App\Services\Cliente\ClienteService;
use App\Services\ListaPorc\ListaPorcService;
use App\Services\Articulo\ArticuloService;
use App\Services\PreArt\PreArtService;
use App\Services\Oferta\OfertaService;
use App\Helper\ApiResponse;
use App\Helper\Precios\ConstruirJoinYFiltros;
use App\Helper\Precios\ConstruirParametrosCliente;
use App\Helper\Precios\ConstruirColumnas;
use App\Helper\Precios\ConstruirPrecios;

class PrecioController extends Controller
{
    protected $parametroService;
    protected $tipCtaService;
    protected $clienteService;
    protected $listaPorcService;
    protected $articuloService;
    protected $preArtService;
    protected $ofertaService;
    protected $apiResponse;
    protected $construirJoinYFiltro;
    protected $parametrosCliente;
    protected $construirColumnas;
    protected $construirPrecios;

    public function __construct(
        ParametrosService $parametroService,
        TipCtaService $tipCtaService,
        ClienteService $clienteService,
        ListaPorcService $listaPorcService,
        ArticuloService $articuloService,
        PreArtService $preArtService,
        OfertaService $ofertaService,
        ApiResponse $apiResponse,
        ConstruirJoinYFiltros $construirJoinYFiltro,
        ConstruirParametrosCliente $parametrosCliente,
        ConstruirColumnas $construirColumnas,
        ConstruirPrecios $construirPrecios,
    ) {
        $this->parametroService = $parametroService;
        $this->tipCtaService = $tipCtaService;
        $this->clienteService = $clienteService;
        $this->listaPorcService = $listaPorcService;
        $this->articuloService = $articuloService;
        $this->preArtService = $preArtService;
        $this->ofertaService = $ofertaService;
        $this->apiResponse = $apiResponse;
        $this->construirJoinYFiltro = $construirJoinYFiltro;
        $this->parametrosCliente = $parametrosCliente;
        $this->construirColumnas = $construirColumnas;
        $this->construirPrecios = $construirPrecios;
    }

    public function obtenerPrecio(ObtenerPrecioRequest $request)
    {
        try {
            $datosRecibidos = $request->obtenerDatosCalculoDePrecio();
            $filtros = $this->construirJoinYFiltro->construirJoinYFiltro($datosRecibidos);
            $parametros = $this->parametroService->obtenerParametros();
            $cliente = $this->clienteService->datosCliente($datosRecibidos->clicod);
            $parametrosCliente = $this->parametrosCliente->construirParametrosCliente($cliente, $datosRecibidos, $parametros);
            $descuentos = $this->tipCtaService->obtenerDescuentos($parametrosCliente->condvta, $parametrosCliente->formpag);

            if ($parametros->par_listaporc == 1) {
                $listaData = $this->listaPorcService->obtenerListaData($parametrosCliente->listac, $parametros->par_ListaPDef, 0);
                if ($listaData) {
                    $porcentajes = [
                        $listaData->lis_porc1,
                        $listaData->lis_porc2,
                        $listaData->lis_porc3,
                        $listaData->lis_porc4
                    ];
                    $baseCol = $this->construirColumnas->obtenerColumnas($listaData->lis_base);
                    $columnaprecio = $this->construirPrecios->construirPrecios($baseCol, $porcentajes);
                    list($columnaprecio, $txtiva, $coniva) = $this->procesarIvaConLista($columnaprecio, $parametrosCliente->categoriaTipo, $parametros);
                }
            } else {
                list($columnaprecio, $txtiva, $coniva) = $this->procesarIvaSinLista($parametrosCliente->categoriaTipo, $parametros);
            }

            $articulo = $this->articuloService->obtenerArticuloPrecio(
                $datosRecibidos->codtex,
                $datosRecibidos->codnum,
                $columnaprecio,
                strlen($parametros->par_decimales),
                $filtros->joinAdicional,
                $filtros->filtroAdicional
            );

            $ofertaDescuentos = array_fill(0, 6, 0);
            $ofertasUsuario = null;

            if ($datosRecibidos->bandera) {
                $preArt = $this->preArtService->obtenerDescuentos(
                    $datosRecibidos->clicod,
                    $articulo['fabrica'],
                    $parametrosCliente->condvta,
                    $articulo['articulo'],
                    $articulo['linea'],
                    $articulo['rubro'],
                    $datosRecibidos->cant,
                );

                $oferta = $this->ofertaService->obtenerOfertaPrecio(
                    $parametrosCliente->categoria,
                    $articulo['fabrica'],
                    $articulo['articulo'],
                    $datosRecibidos->cant,
                    $articulo['linea'],
                    $articulo['rubro'],
                    0
                );

                if ($oferta) {
                    $descuentosAplicables = [
                        $oferta->ofe_dto1 ?? 0,
                        $oferta->ofe_dto2 ?? 0,
                        $oferta->ofe_dto3 ?? 0,
                        $oferta->ofe_dto4 ?? 0,
                        $oferta->ofe_dto5 ?? 0,
                        $oferta->ofe_dto6 ?? 0
                    ];
                } else {
                    $ofertaDescuentos = [
                        $preArt->pra_dto1 ?? 0,
                        $preArt->pra_dto2 ?? 0,
                        $preArt->pra_dto3 ?? 0,
                        $preArt->pra_dto4 ?? 0,
                        $preArt->pra_dto5 ?? 0,
                        $preArt->pra_dto6 ?? 0,
                    ];
                }
            }

            $descuentosAplicables = array_merge(
                [
                    $descuentos['desa'] ?? 0,
                    $descuentos['desb'] ?? 0,
                    $descuentos['desc'] ?? 0,
                    $descuentos['desd'] ?? 0,
                    $descuentos['descto'] ?? 0
                ],
                $ofertaDescuentos
            );

            $dto_web = 0;
            if ($dto_web != 0) {
                foreach ($descuentosAplicables as &$descuento) {
                    if ((empty($descuento) || $descuento == 0) && $datosRecibidos->bandera != '1') {
                        $descuento = $dto_web;
                        $datosRecibidos->bandera = '1';
                        break;
                    }
                }
                unset($descuento);
            }

            $precio = $articulo['precio'];
            $precioOriginal = $precio;
            foreach ($descuentosAplicables as $descuento) {
                if ($descuento) {
                    $precio *= (1 + $descuento / 100);
                }
            }

            $preciofinal = round($precio, strlen($parametros->par_decimales));
            $totalDescuentos = array_sum(array_filter($descuentosAplicables, fn($descuento) => !empty($descuento)));

            return response()->json([
                "precioLista"    => (float)$articulo['precio'],
                "precioInicial"  => $precio,
                "precio"         => $preciofinal,
                "iva"            => $txtiva,
                "des1"           => $ofertaDescuentos[0],
                "des2"           => $ofertaDescuentos[1],
                "des3"           => $ofertaDescuentos[2],
                "des4"           => $ofertaDescuentos[3],
                "des5"           => $ofertaDescuentos[4],
                "des6"           => $ofertaDescuentos[5],
                "desa"           => $descuentos['desa'] ?? 0,
                "desb"           => $descuentos['desb'] ?? 0,
                "desc"           => $descuentos['desc'] ?? 0,
                "desd"           => $descuentos['desd'] ?? 0,
                "descto"         => $descuentos['descto'] ?? 0,
                "ofertasUsuario" => $ofertasUsuario,
                "descuentos"     => $totalDescuentos
            ]);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }

    private function procesarIvaConLista($priceExpr, $categoriaTipo, $parametros)
    {
        if ($categoriaTipo == 1) {
            return $this->procesarPrecioParaIVA($priceExpr, $parametros->par_minorista, $parametros->par_ivaMi);
        } else {
            return $this->procesarPrecioParaIVA($priceExpr,  $parametros->par_mayorist,  $parametros->par_ivaMa);
        }
    }

    private function procesarPrecioParaIVA($priceExpr, $aplicar, $ivaIncluido)
    {
        if ($aplicar == 1 && $ivaIncluido == 1) {
            $priceExpr = "($priceExpr) * (1 + (art_aliva / 100.0))";
        } elseif ($aplicar == 0 && $ivaIncluido == 0) {
            $priceExpr = "($priceExpr) / (1 + (art_aliva / 100.0))";
        }

        $txtiva = $ivaIncluido == 1
            ? '<strong style="color:green;font-size:70%;">IVA Incluido</strong>'
            : '<strong style="color:red;font-size:70%;">Sin IVA</strong>';

        $coniva = $ivaIncluido;

        return [
            'priceExpr' => $priceExpr,
            'txtiva' => $txtiva,
            'coniva' => $coniva
        ];
    }

    private function procesarIvaSinLista($categoriaTipo, $parametros)
    {
        if ($categoriaTipo == 1) {
            $basePrice = "art_precmino";
            if ($parametros->par_minorista == 1 && $parametros->par_ivaM == 1) {
                $priceExpr = "$basePrice*(1 + (art_aliva / 100.0))";
            } elseif ($parametros->par_minorista == 0 && $parametros->par_ivaM == 0) {
                $priceExpr = "$basePrice/(1 + (art_aliva / 100.0))";
            } else {
                $priceExpr = $basePrice;
            }
            $txtiva = $parametros->par_ivaM == 1
                ? '<strong style="color:green;font-size:70%;"> IVA Incluido</strong>'
                : '<strong style="color:red;font-size:70%;"> Sin IVA</strong>';
            $coniva = $parametros->par_ivaM;
        } else {
            $basePrice = "art_precmayo";
            if ($parametros->par_mayorista == 1 && $parametros->par_ivaMa == 1) {
                $priceExpr = "$basePrice*(1 + (art_aliva / 100.0))";
            } elseif ($parametros->par_mayorista == 0 && $parametros->par_ivaMa == 0) {
                $priceExpr = "$basePrice/(1 + (art_aliva / 100.0))";
            } else {
                $priceExpr = $basePrice;
            }
            $txtiva = $parametros->par_ivaMa == 1
                ? '<strong style="color:green;font-size:70%;"> IVA Incluido</strong>'
                : '<strong style="color:red;font-size:70%;"> Sin IVA</strong>';
            $coniva = $parametros->par_ivaMa;
        }

        return [$priceExpr, $txtiva, $coniva];
    }
}