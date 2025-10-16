<?php

namespace App\Http\Controllers;

use App\Services\Rubro\RubroService;
use App\Services\Articulo\ArticuloService;
use App\Helper\ApiResponse;

class RubroController extends Controller
{
    protected $rubroService;
    protected $articuloService;
    protected $apiResponse;

    public function __construct(
        RubroService $rubroService,
        ArticuloService $articuloService,
        ApiResponse $apiResponse
    ) {
        $this->rubroService = $rubroService;
        $this->articuloService = $articuloService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerRubros()
    {
        try {
            $rubros = $this->rubroService->obtenerRubros();

            if ($rubros->isEmpty()) {
                return $this->apiResponse->notFound('No existen rubros en la BD');
            }

            return response()->json($rubros);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }

    public function obtenerArticulosPorRubro($codigo)
    {
        try {
            $articulos = $this->articuloService->obtenerArticulosPorRubro($codigo);

            if ($articulos->isEmpty()) {
                return $this->apiResponse->notFound('No existen artículos de ese rubro en la BD');
            }

            return response()->json($articulos);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }

    public function obtenerRubrosPorLinea($linea)
    {
        try {
            $rubros = $this->rubroService->obtenerRubrosPorLinea($linea);

            if ($rubros->isEmpty()) {
                return $this->apiResponse->notFound('No existen rubros para esta línea en la BD');
            }

            return response()->json($rubros);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}