<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\ActualizarClienteRequest;
use App\Services\Cliente\ClienteService;
use App\Helper\ApiResponse;

class ClienteActualizarClienteClienteController extends Controller
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

    public function actualizarCliente($id, ActualizarClienteRequest $request)
    {
        try {
            $datosAActualizar = $request->datosActualizarCliente();

            $resultado = $this->clienteService->actualizarCliente($id, $datosAActualizar);

            if (!$resultado) {
                return response()->json('No se pudo actualizar el cliente', 400);
            }

            return response()->json('OK');
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}