<?php

namespace App\Http\Controllers\Cliente;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\ObtenerClientesRequest;
use App\Services\Cliente\ClienteService;

class ClienteObtenerClientesController extends Controller
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

    public function obtenerClientes(ObtenerClientesRequest $request)
    {
        $cuit = $request->obtenerCUIT();
        $dni  = $request->obtenerDNI();

        try {
            $clientes = $this->clienteService->obtenerClientes($cuit, $dni);

            if ($clientes->isEmpty()) {
                return response()->json([[]], 200);
            }

            return response()->json($clientes);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}