<?php

namespace App\Http\Controllers;

use App\Services\Empresa\EmpresaService;
use App\Helper\ApiResponse;

class EmpresaController extends Controller
{
    protected $empresaService;
    protected $apiResponse;

    public function __construct(
        EmpresaService $empresaService,
        ApiResponse $apiResponse
    ) {
        $this->empresaService = $empresaService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerEmpresa()
    {
        try {
            $empresa = $this->empresaService->obtenerEmpresa();

            if (!$empresa) {
                return $this->apiResponse->notFound('No existe la empresa en la BD');
            }

            return response()->json($empresa);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e, 'Error al obtener la información de la empresa');
        }
    }
}