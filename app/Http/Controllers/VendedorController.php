<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponse;
use App\Http\Requests\Vendedor\ClientesDelVendedorRequest;
use App\Services\Vendedor\VendedorService;

class VendedorController extends Controller
{
    protected $apiResponse;
    protected $vendedorService;

    public function __construct(
        ApiResponse $apiResponse,
        VendedorService $vendedorService
    ) {
        $this->apiResponse = $apiResponse;
        $this->vendedorService = $vendedorService;
    }

    public function obtenerVendedores()
    {
        try {
            $vendedores = $this->vendedorService->obtenerVendedoresActivos();

            if ($vendedores->isEmpty()) {
                return $this->apiResponse->notFound('No existen vendedores en la BD');
            }

            return response()->json($vendedores);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }

    public function clientesDelVendedor(ClientesDelVendedorRequest $request)
    {
        try {
            $cli_vendedor = $request->cli_vendedor;

            $clientes = $this->vendedorService->obtenerClientesDelVendedor($cli_vendedor);

            if ($clientes->isEmpty()) {
                return $this->apiResponse->notFound('No existen clientes del vendedor en la BD');
            }

            return response()->json($clientes);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}