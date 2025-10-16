<?php

namespace App\Services\Novedad;

use App\Repository\Novedad\NovedadContarCantidadNovededRepository;
use App\Repository\Novedad\NovedadObtenerNovedadesRepository;
use App\Repository\Novedad\NovedadObtenerTiposDeNovedadRepository;

class NovedadService
{
    protected NovedadContarCantidadNovededRepository $novedadContarCantidadNovedadRepo;
    protected NovedadObtenerNovedadesRepository $novedadObtenerNovedadesRepo;
    protected NovedadObtenerTiposDeNovedadRepository $novedadObtenerTiposDeNovedadRepo;

    public function __construct(
        NovedadContarCantidadNovededRepository $novedadContarCantidadNovedadRepo,
        NovedadObtenerNovedadesRepository $novedadObtenerNovedadesRepo,
        NovedadObtenerTiposDeNovedadRepository $novedadObtenerTiposDeNovedadRepo,
    ) {
        $this->novedadContarCantidadNovedadRepo = $novedadContarCantidadNovedadRepo;
        $this->novedadObtenerNovedadesRepo = $novedadObtenerNovedadesRepo;
        $this->novedadObtenerTiposDeNovedadRepo = $novedadObtenerTiposDeNovedadRepo;
    }

    public function cantidadNovedad($condicionTipoProd)
    {
        return $this->novedadContarCantidadNovedadRepo->cantidadNovedad($condicionTipoProd);
    }

    public function obtenerNovedades($hostIMG, $precioObtenido, $art_precio, $order_by, $cli_categoria, $TIPPROD,$precioMax, $precioMin, $min, $max)
    {
        return $this->novedadObtenerNovedadesRepo->obtenerNovedades($hostIMG, $precioObtenido, $art_precio, $order_by, $cli_categoria, $TIPPROD,$precioMax, $precioMin, $min, $max);
    }

    public function obtenerTiposDeNovedades()
    {
        return $this->novedadObtenerTiposDeNovedadRepo->obtenerTiposDeNovedades();
    }
}