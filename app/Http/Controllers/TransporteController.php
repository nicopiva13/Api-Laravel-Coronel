<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transporte\ObtenerTransporteRequest;
use App\Services\Transporte\TransporteService;
use App\Helper\ApiResponse;

class TransporteController extends Controller
{
    protected $transporteService;
    protected $apiResponse;

    public function __construct(
        TransporteService $transporteService,
        ApiResponse $apiResponse
    ) {
        $this->transporteService = $transporteService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerTransporte(ObtenerTransporteRequest $request)
    {
        try {
            $codigo = $request->C;

            $transporte = $this->transporteService->obtenerTransporte($codigo);

            if ($transporte->isEmpty()) {
                return $this->apiResponse->notFound('No existen transportes en la BD');
            }

            return response()->json($transporte);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}