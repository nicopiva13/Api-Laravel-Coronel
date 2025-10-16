<?php

namespace App\Http\Controllers\Cliente;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Cliente\ClienteService;

class ClienteObtenerDatosClienteController extends Controller
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

    public function obtenerDatosCliente($numCliente)
    {
        try {
            $cliente = $this->clienteService->obtenerDatosCliente($numCliente);

            if (!$cliente) {
                return $this->apiResponse->notFound('No existe ese cliente en la BBDD');
            }

            return response()->json([$cliente]);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}