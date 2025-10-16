<?php

namespace App\Services\Rubro;

use App\Repository\Rubro\RubroObtenerRubrosRepository;
use App\Repository\Rubro\RubroObtenerRubrosPorLineaRepository;

class RubroService
{
    protected RubroObtenerRubrosRepository $rubroObtenerRubrosRepo;
    protected RubroObtenerRubrosPorLineaRepository $rubroObtenerRubrosPorLineasRepo;

    public function __construct(
        RubroObtenerRubrosRepository $rubroObtenerRubrosRepo,
        RubroObtenerRubrosPorLineaRepository $rubroObtenerRubrosPorLineasRepo,
    ) {
        $this->rubroObtenerRubrosRepo = $rubroObtenerRubrosRepo;
        $this->rubroObtenerRubrosPorLineasRepo = $rubroObtenerRubrosPorLineasRepo;
    }

    public function obtenerRubros()
    {
        return $this->rubroObtenerRubrosRepo->obtenerRubros();
    }    
    
    public function obtenerRubrosPorLinea($linea)
    {
        return $this->rubroObtenerRubrosPorLineasRepo->obtenerRubrosPorLinea($linea);
    }
}