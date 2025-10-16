<?php

namespace App\Http\Controllers\Cliente;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\ObtenerCondicionClienteRequest;
use App\Services\Cliente\ClienteService;

class ClienteObtenerCondicionClienteController extends Controller
{
    protected $clienteService;
    protected $apiResponse;

    public function __construct(
        ClienteService $clienteService,
        ApiResponse $apiResponse,
    ) {
        $this->clienteService = $clienteService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerCondicionCliente(ObtenerCondicionClienteRequest $request)
    {
        $cli_codigo = $request->cli_codigo;

        try {
            $cliente = $this->clienteService->obtenerCondicionCliente($cli_codigo);

            if ($cliente->isEmpty()) {
                return $this->apiResponse->notFound('No se encontraron datos para el cliente');
            }

            return response()->json($cliente, 200);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}