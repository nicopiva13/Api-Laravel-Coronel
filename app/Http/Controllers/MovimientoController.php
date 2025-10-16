<?php

namespace App\Http\Controllers;

use App\Services\MovVta\MovVtaService;
use App\Helper\ApiResponse;

class MovimientoController extends Controller
{
    protected $movVtaService;
    protected $apiResponse;

    public function __construct(
        MovVtaService $movVtaService,
        ApiResponse $apiResponse
    ) {
        $this->movVtaService = $movVtaService;
        $this->apiResponse = $apiResponse;
    }
    
    public function obtenerMovimientos($codigo)
    {
        try {
            $movimientos = $this->movVtaService->obtenerMovimientos($codigo);

            if ($movimientos->isEmpty()) {
                return $this->apiResponse->notFound('No existen movimientos en la BD');
            }

            return response()->json($movimientos);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}