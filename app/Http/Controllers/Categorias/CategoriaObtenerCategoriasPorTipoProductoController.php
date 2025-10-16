<?php

namespace App\Http\Controllers\Categorias;

use App\Http\Controllers\Controller;
use App\Helper\ApiResponse;
use App\Services\Categoria\CategoriaService;

class CategoriaObtenerCategoriasPorTipoProductoController extends Controller
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

    public function obtenerCategoriasPorTipoProducto($tipoProducto)
    {
        try {
            $categorias = $this->categoriaService->obtenerCategoriasPorTipoProducto($tipoProducto);

            return response()->json($categorias);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}