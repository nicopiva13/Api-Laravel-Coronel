<?php

namespace App\Http\Controllers;

use App\Http\Requests\Marcas\ObtenerMarcasRequest;
use App\Services\Marcas\MarcasService;
use App\Helper\ApiResponse;

class MarcaController extends Controller
{
    protected $marcasService;
    protected $apiResponse;

    public function __construct(
        MarcasService $marcasService,
        ApiResponse $apiResponse
    ) {
        $this->marcasService = $marcasService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerMarcas(ObtenerMarcasRequest $request)
    {
        $params = $request->validated();

        try {
            $marcas = $this->marcasService->obtenerMarcas($params);

            if ($marcas->isEmpty()) {
                return $this->apiResponse->notFound('No existen fábricas en la BD');
            }

            return response()->json($marcas);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}