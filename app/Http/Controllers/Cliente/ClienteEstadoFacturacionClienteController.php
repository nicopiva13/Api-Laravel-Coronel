<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Services\Cliente\ClienteService;
use App\Helper\ApiResponse;

class ClienteEstadoFacturacionClienteController extends Controller
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

    public function estadoFacturacionCliente($cli_codigo)
    {
        try {
            $resultado = $this->clienteService->obtenerEstadoFacturacion($cli_codigo);

            if ($resultado === null) {
                return $this->apiResponse->notFound('No existe ese cliente en la BBDD');
            }

            return response()->json(['recibe_mail' => (bool) $resultado]);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}