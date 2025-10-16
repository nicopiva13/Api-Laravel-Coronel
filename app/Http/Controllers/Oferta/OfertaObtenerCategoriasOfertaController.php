<?php

namespace App\Http\Controllers\Novedad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Oferta\ObtenerCategoriaOfertaRequest;
use App\Services\Oferta\OfertaService;
use App\Helper\ApiResponse;

class OfertaObtenerCategoriasOfertaController extends Controller
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

    public function obtenerCategoriaOferta(ObtenerCategoriaOfertaRequest $request)
    {
        try {
            $categorias = $this->ofertaService->obtenerCategoriasOferta($request->CAT);

            if ($categorias->isEmpty()) {
                return $this->apiResponse->notFound("No existen categorías con oferta.");
            }

            return response()->json($categorias);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e, "Error al obtener categorías de oferta.");
        }
    }
}