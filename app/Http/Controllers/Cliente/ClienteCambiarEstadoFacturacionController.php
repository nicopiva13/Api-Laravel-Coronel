<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\CambiarEstadoFacturacionRequest;
use App\Services\Cliente\ClienteService;
use App\Helper\ApiResponse;

class ClienteCambiarEstadoFacturacionController extends Controller
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

    public function cambiarEstadoFacturacion(CambiarEstadoFacturacionRequest $request, $cli_codigo)
    {
        try {
            $actualizados = $this->clienteService->actualizarEstadoFacturacion(
                $cli_codigo,
                $request->input('cli_FERecibeMail')
            );

            if (!$actualizados) {
                return $this->apiResponse->notFound('No existe ese cliente en la BBDD');
            }

            return response()->json(['mensaje' => 'Cliente actualizado correctamente'], 200);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}