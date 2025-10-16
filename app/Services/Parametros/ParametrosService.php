<?php

namespace App\Services\Parametros;

use App\Repository\Parametros\ParametrosObtenerTodosLosParametrosRepository;
use App\Repository\Parametros\ParametrosObtenerParametrosRepository;
use App\Repository\Parametros\ParametrosObtenerCondVentaRepository;

class ParametrosService
{
    protected ParametrosObtenerTodosLosParametrosRepository $parametrosObtenerTodosLosParametrosRepo;
    protected ParametrosObtenerParametrosRepository $parametrosObtenerParametrosRepo;
    protected ParametrosObtenerCondVentaRepository $parametrosObtenerCondVentaRepo;

    public function __construct(
        ParametrosObtenerTodosLosParametrosRepository $parametrosObtenerTodosLosParametrosRepo,
        ParametrosObtenerParametrosRepository $parametrosObtenerParametrosRepo,
        ParametrosObtenerCondVentaRepository $parametrosObtenerCondVentaRepo,
    ) {
        $this->parametrosObtenerTodosLosParametrosRepo = $parametrosObtenerTodosLosParametrosRepo;
        $this->parametrosObtenerParametrosRepo = $parametrosObtenerParametrosRepo;
        $this->parametrosObtenerCondVentaRepo = $parametrosObtenerCondVentaRepo;
    }

    public function obtenerTodosLosParametros()
    {
        return $this->parametrosObtenerTodosLosParametrosRepo->obtenerTodosLosParametros();
    }

    public function obtenerParametros()
    {
        return $this->parametrosObtenerParametrosRepo->obtenerParametros();
    }

    public function obtenerCondVenta()
    {
        return $this->parametrosObtenerCondVentaRepo->obtenerCondVenta();
    }
}