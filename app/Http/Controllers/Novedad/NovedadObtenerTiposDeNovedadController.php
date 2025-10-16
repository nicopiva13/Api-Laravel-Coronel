<?php

namespace App\Http\Controllers\Novedad;

use App\Http\Controllers\Controller;
use App\Services\Novedad\NovedadService;
use App\Helper\ApiResponse;

class NovedadObtenerTiposDeNovedadController extends Controller
{
    protected $novedadService;
    protected $apiResponse;

    public function __construct(
        NovedadService $novedadService,
        ApiResponse $apiResponse
    ) {
        $this->novedadService = $novedadService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerCategoriasEnNovedad()
    {
        try {
            $categorias = $this->novedadService->obtenerTiposDeNovedades();

            if ($categorias->isEmpty()) {
                return $this->apiResponse->notFound('No existen categorías con oferta.');
            }

            return response()->json($categorias, 200);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e, 'Error al obtener las categorías en novedad.');
        }
    }
}