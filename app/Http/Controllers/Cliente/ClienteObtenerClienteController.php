<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Services\Cliente\ClienteService;
use App\Helper\ApiResponse;

class ClienteObtenerClienteController extends Controller
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

    public function obtenerCliente($codigo)
    {
        try {
            $cliente = $this->clienteService->obtenerCliente($codigo);

            if (is_null($cliente)) {
                return $this->apiResponse->notFound('Cliente no encontrado');
            }

            return response()->json([$cliente]);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}