<?php

namespace App\Http\Controllers;

use App\Services\Localidad\LocalidadService;
use App\Helper\ApiResponse;

class LocalidadController extends Controller
{
    protected $localidadService;
    protected $apiResponse;

    public function __construct(
        LocalidadService $localidadService,
        ApiResponse $apiResponse
    ) {
        $this->localidadService = $localidadService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerLocalidades()
    {
        try {
            $localidades = $this->localidadService->obtenerTodasLasLocalidades();

            if ($localidades->isEmpty()) {
                return $this->apiResponse->notFound('No existen localidades en la BD');
            }

            return response()->json($localidades);
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
