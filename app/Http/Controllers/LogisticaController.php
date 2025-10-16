<?php

namespace App\Http\Controllers;

use App\Services\Cliente\ClienteService;
use App\Http\Requests\Clientes\ObtenerClientesLogisticaRequest;
use App\Helper\ApiResponse;

class LogisticaController extends Controller
{
    protected $clienteService;
    protected $apiResponse;

    public function __construct(
        ClienteService $clienteService,
        ApiResponse $apiResponse
    ) {
        $this->clienteService = $clienteService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerClientes(ObtenerClientesLogisticaRequest $request)
    {
        $provincia = $request->P;

        try {
            $clientes = $this->clienteService->obtenerClientesLogistica($provincia);

            if ($clientes->isEmpty()) {
                return $this->apiResponse->notFound('No existen clientes en la BD');
            }

            return response()->json($clientes);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }

    public function obtenerClientesPorCodigo($codigo)
    {
        try {
            $cliente = $this->clienteService->obtenerClientePorCodigoLogistica($codigo);

            if (!$cliente) {
                return $this->apiResponse->notFound('No existe cliente en la BD');
            }

            return response()->json($cliente);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}