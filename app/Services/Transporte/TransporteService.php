<?php

namespace App\Services\Transporte;

use App\Repository\Transporte\TransporteRepository;

class TransporteService
{
    protected TransporteRepository $transporteRepo;

    public function __construct(
        TransporteRepository $transporteRepo,
    ) {
        $this->transporteRepo = $transporteRepo;
    }

    public function obtenerTransporte($codigo = null)
    {
        return $this->transporteRepo->obtenerTransporte($codigo);
    }
}