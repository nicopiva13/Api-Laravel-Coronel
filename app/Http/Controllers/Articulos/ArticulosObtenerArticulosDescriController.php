<?php

namespace App\Http\Controllers\Articulos;

use App\Http\Controllers\Controller;
use App\Services\Articulo\ArticuloService;
use App\Helper\ApiResponse;

class ArticulosObtenerArticulosDescriController extends Controller
{
    protected $articuloService;
    protected $apiResponse;

    public function __construct(
        ArticuloService $articuloService,
        ApiResponse $apiResponse
    ) {
        $this->articuloService = $articuloService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerArticulosDescri($fabrica, $codigo)
    {
        try {
            $articulos = $this->articuloService->obtenerArticulosDescri($fabrica, $codigo);

            if ($articulos->isEmpty()) {
                return $this->apiResponse->notFound('No se encontraron artículos');
            }

            return response()->json($articulos, 200);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}