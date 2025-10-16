<?php

namespace App\Http\Controllers;

use App\Services\Parametros\ParametrosService;
use App\Helper\ApiResponse;

class ParametroController extends Controller
{
    protected $parametrosService;
    protected $apiResponse;

    public function __construct(
        ParametrosService $parametrosService,
        ApiResponse $apiResponse
    ) {
        $this->parametrosService = $parametrosService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerParametros()
    {
        try {
            $parametros = $this->parametrosService->obtenerTodosLosParametros();

            if (!$parametros) {
                return $this->apiResponse->notFound('No existen parámetros en la BD');
            }

            return response()->json($parametros);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}