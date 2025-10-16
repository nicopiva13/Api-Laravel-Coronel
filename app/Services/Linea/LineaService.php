<?php

namespace App\Services\Linea;

use App\Repository\Linea\LineaObtenerLineasPorMarcaRepository;

class LineaService
{
    protected LineaObtenerLineasPorMarcaRepository $lineaObtenerLineasPorMarcaRepo;

    public function __construct(
        LineaObtenerLineasPorMarcaRepository $lineaObtenerLineasPorMarcaRepo,
    ) {
        $this->lineaObtenerLineasPorMarcaRepo = $lineaObtenerLineasPorMarcaRepo;
    }

    public function obtenerLineasPorMarca($marca)
    {
        return $this->lineaObtenerLineasPorMarcaRepo->obtenerLineasPorMarca($marca);
    } 
}