<?php

namespace App\Http\Controllers\Oferta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Oferta\ArticulosEnOfertaRequest;
use App\Services\Oferta\OfertaService;
use App\Helper\ApiResponse;

class OfertaArticulosEnOFertaSegunCategoriaController extends Controller
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

    public function articulosEnOfertaSegunCategoria(ArticulosEnOfertaRequest $request)
    {
        try {
            $ofertas = $this->ofertaService->obtenerArticulosPorCategoria($request->cli_categoria);

            if ($ofertas->isEmpty()) {
                return $this->apiResponse->notFound("No se encontraron artículos en oferta para esta categoría.");
            }

            return response()->json($ofertas);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e, "Error al consultar artículos en oferta.");
        }
    }
}