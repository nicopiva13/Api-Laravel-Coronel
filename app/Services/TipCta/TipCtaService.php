<?php

namespace App\Services\TipCta;

use App\Repository\TipCta\TipCtaObtenerCondicionesDeVentasActivasRepository;
use App\Repository\TipCta\TipCtaObtenerDescuentosRepository;

class TipCtaService
{
    protected TipCtaObtenerCondicionesDeVentasActivasRepository $tipCtaObtenerCondicionesDeVentasActivasRepo;
    protected TipCtaObtenerDescuentosRepository $tipCtaObtenerDescuentosRepo;

    public function __construct(
        TipCtaObtenerCondicionesDeVentasActivasRepository $tipCtaObtenerCondicionesDeVentasActivasRepo,
        TipCtaObtenerDescuentosRepository $tipCtaObtenerDescuentosRepo,
    ) {
        $this->tipCtaObtenerCondicionesDeVentasActivasRepo = $tipCtaObtenerCondicionesDeVentasActivasRepo;
        $this->tipCtaObtenerDescuentosRepo = $tipCtaObtenerDescuentosRepo;
    }

    public function obtenerCondicionesVentaActivas()
    {
        return $this->tipCtaObtenerCondicionesDeVentasActivasRepo->obtenerCondicionesVentaActivas();
    }
    
    public function obtenerDescuentos($condvta, $formpag)
    {
        return $this->tipCtaObtenerDescuentosRepo->obtenerDescuentos($condvta, $formpag);
    }
}