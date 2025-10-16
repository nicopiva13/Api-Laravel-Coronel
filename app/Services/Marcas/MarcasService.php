<?php

namespace App\Services\Marcas;

use App\Repository\Marcas\MarcasObtenerMarcasRepository;

class MarcasService
{
    protected MarcasObtenerMarcasRepository $marcasObtenerMarcasRepo;

    public function __construct(
        MarcasObtenerMarcasRepository $marcasObtenerMarcasRepo,
    ) {
        $this->marcasObtenerMarcasRepo = $marcasObtenerMarcasRepo;
    }

    public function obtenerMarcas($params)
    {
        return $this->marcasObtenerMarcasRepo->obtenerMarcas($params);
    }
}