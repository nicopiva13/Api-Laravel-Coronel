<?php

namespace App\Http\Controllers;

use App\Services\CondicionIva\CondicionIvaService;
use App\Helper\ApiResponse;

class CondIvaController extends Controller
{
    protected $condicionIvaService;
    protected $apiResponse;

    public function __construct(
        CondicionIvaService $condicionIvaService,
        ApiResponse $apiResponse
    ) {
        $this->condicionIvaService = $condicionIvaService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerCondicionesIva()
    {
        try {
            $condicionesIva = $this->condicionIvaService->obtenerCondicionesIvaVigentes();

            if ($condicionesIva->isEmpty()) {
                return $this->apiResponse->notFound('No se encontró ninguna condición de IVA');
            }

            return response()->json($condicionesIva);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e, 'Error interno del servidor');
        }
    }

    public function obtenerCondicionIva($id)
    {
        try {
            $condicionIva = $this->condicionIvaService->obtenerCondicionIvaPorId($id);

            if ($condicionIva->isEmpty()) {
                return $this->apiResponse->notFound("No se encontró la condición de IVA con el código {$id}");
            }

            return response()->json($condicionIva);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e, 'Error al obtener la condición de IVA');
        }
    }
}