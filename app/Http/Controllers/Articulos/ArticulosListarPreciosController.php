<?php

namespace App\Http\Controllers\Articulos;

use App\Http\Controllers\Controller;
use App\Services\Articulo\ArticuloService;
use App\Helper\ApiResponse;

class ArticulosListarPreciosController extends Controller
{
    protected $articuloService;
    protected $apiResponse;

    public function __construct(
        ArticuloService $articuloService,
        ApiResponse $apiResponse,
    ) {
        $this->articuloService = $articuloService;
        $this->apiResponse = $apiResponse;
    }

    public function listaPrecios($fabrica)
    {
        try {
            $listaPrecio = $this->articuloService->listaPreciosArticulos($fabrica);

            if ($listaPrecio->isEmpty()) {
                return $this->apiResponse->notFound('No existen líneas en la BD');
            }

            return response()->json($listaPrecio, 200);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}