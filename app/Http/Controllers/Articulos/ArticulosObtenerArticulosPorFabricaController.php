<?php

namespace App\Http\Controllers\Articulos;

use App\Http\Controllers\Controller;
use App\Services\Articulo\ArticuloService;

class ArticulosObtenerArticulosPorFabricaController extends Controller
{
    protected $articuloService;

    public function __construct(
        ArticuloService $articuloService,
    ) {
        $this->articuloService = $articuloService;
    }
    
    public function obtenerArticulosPorFabrica($fabrica)
    {
        try {
            $articulosFabrica = $this->articuloService->obtenerArticulosPorFabrica($fabrica);

            if ($articulosFabrica->isEmpty()) {
                return response()->json(['mensaje' => 'No existen artículos en la BD'], 404);
            }
            return response()->json($articulosFabrica);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la base de datos: ' . $e->getMessage()], 500);
        }
    }
}