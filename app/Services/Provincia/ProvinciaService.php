<?php

namespace App\Services\Provincia;

use App\Repository\Provincia\ProvinciaObtenerProvinciasRepository;

class ProvinciaService
{
    protected ProvinciaObtenerProvinciasRepository $provinciaObtenerProvinciasRepo;

    public function __construct(
        ProvinciaObtenerProvinciasRepository $provinciaObtenerProvinciasRepo,
    ) {
        $this->provinciaObtenerProvinciasRepo = $provinciaObtenerProvinciasRepo;
    }

    public function obtenerProvincias()
    {
        return $this->provinciaObtenerProvinciasRepo->obtenerProvincias();
    }    
}