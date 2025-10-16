<?php

namespace App\Http\Controllers\Oferta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Oferta\ArticuloEnOfertaRequest;
use App\Services\Oferta\OfertaService;
use App\Helper\ApiResponse;

class OfertaArticuloEnOfertaController extends Controller
{
    protected $ofertaService;
    protected $apiResponse;

    public function __construct(
        OfertaService $ofertaService,
        ApiResponse $apiResponse
    ) {
        $this->ofertaService = $ofertaService;
        $this->apiResponse = $apiResponse;
    }

    public function articuloEnOferta(ArticuloEnOfertaRequest $request)
    {
        try {
            $cli_categoria = trim($request->cli_categoria);
            $cod_tex = trim($request->codtex);

            $ofertas = $this->ofertaService->obtenerArticulosEnOferta($cli_categoria, $cod_tex);

            if ($ofertas->isEmpty()) {
                return $this->apiResponse->notFound('No se encontraron ofertas para la categoría proporcionada.');
            }

            return response()->json($ofertas);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e, 'Error al consultar las ofertas del artículo.');
        }
    }
}