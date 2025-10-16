<?php

namespace App\Http\Controllers;

use App\Services\TipCta\TipCtaService;
use App\Helper\ApiResponse;

class CondVtaController extends Controller
{
    protected $tipCtaService;
    protected $apiResponse;

    public function __construct(
        TipCtaService $tipCtaService,
        ApiResponse $apiResponse
    ) {
        $this->tipCtaService = $tipCtaService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerCondVta()
    {
        try {
            $condVta = $this->tipCtaService->obtenerCondicionesVentaActivas();

            if ($condVta->isEmpty()) {
                return $this->apiResponse->notFound('No existen condiciones de venta en la BD');
            }

            return response()->json($condVta);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e, 'Error al obtener condiciones de venta');
        }
    }
}