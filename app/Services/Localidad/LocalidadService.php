<?php

namespace App\Services\Localidad;

use App\Repository\Localidad\LocalidadObtenerTodasLasLocalidadesRepository;
use App\Repository\Localidad\LocalidadObtenerLocalidadPorProvinciaRepository;

class LocalidadService
{
    protected LocalidadObtenerTodasLasLocalidadesRepository $localidadObtenerTodasLasLocalidadesRepo;
    protected LocalidadObtenerLocalidadPorProvinciaRepository $localidadObtenerLocalidadesPorProvinciaRepo;

    public function __construct(
        LocalidadObtenerTodasLasLocalidadesRepository $localidadObtenerTodasLasLocalidadesRepo,
        LocalidadObtenerLocalidadPorProvinciaRepository $localidadObtenerLocalidadesPorProvinciaRepo,
    ) {
        $this->localidadObtenerTodasLasLocalidadesRepo = $localidadObtenerTodasLasLocalidadesRepo;
        $this->localidadObtenerLocalidadesPorProvinciaRepo = $localidadObtenerLocalidadesPorProvinciaRepo;
    }

    public function obtenerTodasLasLocalidades()
    {
        return $this->localidadObtenerTodasLasLocalidadesRepo->obtenerTodasLasLocalidades();
    }
    
    public function obtenerLocalidadesPorProvincia($codigo)
    {
        return $this->localidadObtenerLocalidadesPorProvinciaRepo->obtenerLocalidadesPorProvincia($codigo);
    }    
}