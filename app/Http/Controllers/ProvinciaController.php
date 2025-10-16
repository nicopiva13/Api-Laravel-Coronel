<?php

namespace App\Http\Controllers;

use App\Services\Provincia\ProvinciaService;
use App\Services\Localidad\LocalidadService;
use App\Helper\ApiResponse;

class ProvinciaController extends Controller
{
    protected $provinciaService;
    protected $localidadService;
    protected $apiResponse;

    public function __construct(
        ProvinciaService $provinciaService,
        LocalidadService $localidadService,
        ApiResponse $apiResponse
    ) {
        $this->provinciaService = $provinciaService;
        $this->localidadService = $localidadService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerProvincias()
    {
        try {
            $provincias = $this->provinciaService->obtenerProvincias();

            if ($provincias->isEmpty()) {
                return $this->apiResponse->notFound('No existen provincias en la BD');
            }

            return response()->json($provincias);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }

    public function obtenerLocalidadesPorProvincia($codigo)
    {
        try {
            $localidades = $this->localidadService->obtenerLocalidadesPorProvincia($codigo);

            if ($localidades->isEmpty()) {
                return $this->apiResponse->notFound('No existen localidades de esa provincia en la BD');
            }

            return response()->json($localidades);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}