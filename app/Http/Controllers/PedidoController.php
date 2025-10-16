<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pedido\ObtenerPedidosRequest;
use App\Services\Pedidos\PedidosService;
use App\Helper\ApiResponse;

class PedidoController extends Controller
{
    protected $pedidosService;
    protected $apiResponse;

    public function __construct(
        PedidosService $pedidosService,
        ApiResponse $apiResponse
    ) {
        $this->pedidosService = $pedidosService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerPedidosPorCodigo($codigo, ObtenerPedidosRequest $request)
    {
        try {
            $fecha = $request->fecha;

            $pedidos = $this->pedidosService->obtenerPedidosPorCodigo($codigo, $fecha);

            if ($pedidos->isEmpty()) {
                return $this->apiResponse->notFound('No existen movimientos en la BD');
            }

            return response()->json($pedidos);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}