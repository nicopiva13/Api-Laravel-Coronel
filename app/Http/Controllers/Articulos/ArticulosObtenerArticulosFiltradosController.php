<?php

namespace App\Http\Controllers\Articulos;

use App\Http\Controllers\Controller;
use App\Services\Articulo\ArticuloService;
use App\Helper\ApiResponse;

class ArticulosObtenerArticulosFiltradosController extends Controller
{
    protected $articuloService;
    protected $apiResponse;

    public function __construct(
        ArticuloService $articuloService,
        ApiResponse $apiResponse
    ) {
        $this->articuloService = $articuloService;
        $this->apiResponse = $apiResponse;
    }
    
    public function obtenerArticulosFiltrados($marca, $linea, $rubro, $categoria, $fecdesde, $fechasta)
    {
        try {
            $articulos = $this->articuloService->obtenerArticulosFiltrados($marca, $linea, $rubro, $categoria, $fecdesde, $fechasta);

            if ($articulos->isEmpty()) {
                return $this->apiResponse->notFound('No existen artículos en la BD');
            }

            return response()->json($articulos);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}