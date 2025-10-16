<?php

namespace App\Http\Controllers;

use App\Services\TipoProducto\TipoProductoService;
use App\Helper\ApiResponse;

class TipoProductoController extends Controller
{
    protected $tiposProductoService;
    protected $apiResponse;

    public function __construct(
        TipoProductoService $tiposProductoService,
        ApiResponse $apiResponse
    ) {
        $this->tiposProductoService = $tiposProductoService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerTiposProducto()
    {
        try {
            $tiposProducto = $this->tiposProductoService->obtenerTiposProducto();

            if ($tiposProducto->isEmpty()) {
                return $this->apiResponse->notFound('No se encontraron tipos de productos en la BD');
            }

            return response()->json($tiposProducto);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}