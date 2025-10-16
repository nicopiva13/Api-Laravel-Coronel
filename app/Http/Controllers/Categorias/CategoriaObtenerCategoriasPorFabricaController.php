<?php

namespace App\Http\Controllers\Categorias;

use App\Http\Controllers\Controller;
use App\Helper\ApiResponse;
use App\Services\Categoria\CategoriaService;

class CategoriaObtenerCategoriasPorFabricaController extends Controller
{
    protected $categoriaService;
    protected $apiResponse;

    public function __construct(
        CategoriaService $categoriaService,
        ApiResponse $apiResponse,
    ) {
        $this->categoriaService = $categoriaService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerCategoriasPorFabrica($tipoProducto, $rubro, $linea, $fabrica)
    {
        try {
            $categorias = $this->categoriaService->obtenerCategoriasPorFabrica($tipoProducto, $rubro, $linea, $fabrica);

            if ($categorias->isEmpty()) {
                return $this->apiResponse->notFound('No existen artículos de esa fábrica en la BD');
            }

            return response()->json($categorias);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}