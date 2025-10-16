<?php

namespace App\Services\MovVta;

use App\Repository\MovVta\MovVtaObtenerMovimientosRepository;

class MovVtaService
{
    protected MovVtaObtenerMovimientosRepository $movVtaObtenerMovimientosRepo;

    public function __construct(
        MovVtaObtenerMovimientosRepository $movVtaObtenerMovimientosRepo,
    ) {
        $this->movVtaObtenerMovimientosRepo = $movVtaObtenerMovimientosRepo;
    }

    public function obtenerMovimientos($codigo)
    {
        return $this->movVtaObtenerMovimientosRepo->obtenerMovimientos($codigo);
    }    
}