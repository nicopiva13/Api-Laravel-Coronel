<?php

namespace App\Http\Controllers;

use App\Services\Linea\LineaService;
use App\Helper\ApiResponse;

class LineaController extends Controller
{
    protected $lineaService;
    protected $apiResponse;

    public function __construct(
        LineaService $lineaService,
        ApiResponse $apiResponse
    ) {
        $this->lineaService = $lineaService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerLineas($marca)
    {
        try {
            $lineas = $this->lineaService->obtenerLineasPorMarca($marca);

            if ($lineas->isEmpty()) {
                return $this->apiResponse->notFound('No existen líneas en la BD');
            }

            return response()->json($lineas);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}