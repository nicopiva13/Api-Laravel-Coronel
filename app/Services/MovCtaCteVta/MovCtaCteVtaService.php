<?php

namespace App\Services\MovCtaCteVta;

use App\Repository\MovCtaCteVta\MovCtaCteVtaObtenerMovimientosClienteRepository;
use App\Repository\MovCtaCteVta\MovCtaCteVtaObtenerDebeClienteRepository;
use App\Repository\MovCtaCteVta\MovCtaCteVtaObtenerHaberClienteRepository;
USE App\Repository\MovCtaCteVta\MovCtaCteVtaObtenerMovimientosVendedorRepository;
use App\Repository\MovCtaCteVta\MovCtaCteVtaObtenerDebeVendedorRepository;
use App\Repository\MovCtaCteVta\MovCtaCteVtaObtenerHaberVendedorRepository;

class MovCtaCteVtaService
{
    protected MovCtaCteVtaObtenerMovimientosClienteRepository $movCtaCteVtaObtenerMovimientosClienteRepo;
    protected MovCtaCteVtaObtenerDebeClienteRepository $movCtaCteVtaObtenerDebeClienteRepo;
    protected MovCtaCteVtaObtenerHaberClienteRepository $movCtaCteVtaObtenerHaberClienteRepo;
    protected MovCtaCteVtaObtenerMovimientosVendedorRepository $movCtaCteVtaObtenerMovimientosVendedorRepo;
    protected MovCtaCteVtaObtenerDebeVendedorRepository $movCtaCteVtaObtenerDebeVendedorRepo;
    protected MovCtaCteVtaObtenerHaberVendedorRepository $movCtaCteVtaObtenerHaberVendedorRepo;

    public function __construct(
        MovCtaCteVtaObtenerMovimientosClienteRepository $movCtaCteVtaObtenerMovimientosClienteRepo,
        MovCtaCteVtaObtenerDebeClienteRepository $movCtaCteVtaObtenerDebeClienteRepo,
        MovCtaCteVtaObtenerHaberClienteRepository $movCtaCteVtaObtenerHaberClienteRepo,
        MovCtaCteVtaObtenerMovimientosVendedorRepository $movCtaCteVtaObtenerMovimientosVendedorRepo,
        MovCtaCteVtaObtenerDebeVendedorRepository $movCtaCteVtaObtenerDebeVendedorRepo,
        MovCtaCteVtaObtenerHaberVendedorRepository $movCtaCteVtaObtenerHaberVendedorRepo,
    ) {
        $this->movCtaCteVtaObtenerMovimientosClienteRepo = $movCtaCteVtaObtenerMovimientosClienteRepo;
        $this->movCtaCteVtaObtenerDebeClienteRepo = $movCtaCteVtaObtenerDebeClienteRepo;
        $this->movCtaCteVtaObtenerHaberClienteRepo = $movCtaCteVtaObtenerHaberClienteRepo;
        $this->movCtaCteVtaObtenerMovimientosVendedorRepo = $movCtaCteVtaObtenerMovimientosVendedorRepo;
        $this->movCtaCteVtaObtenerDebeVendedorRepo = $movCtaCteVtaObtenerDebeVendedorRepo;
        $this->movCtaCteVtaObtenerHaberVendedorRepo = $movCtaCteVtaObtenerHaberVendedorRepo;
    }

    public function obtenerMovimientosCliente($clicod, $fechaDesde, $fechaHasta)
    {
        return $this->movCtaCteVtaObtenerMovimientosClienteRepo->obtenerMovimientosCliente($clicod, $fechaDesde, $fechaHasta);
    }

    public function obtenerDebeCliente($clicod, $fechaDesde)
    {
        return $this->movCtaCteVtaObtenerDebeClienteRepo->obtenerDebeCliente($clicod, $fechaDesde);
    }

    public function obtenerHaberCliente($clicod, $fechaDesde)
    {
        return $this->movCtaCteVtaObtenerHaberClienteRepo->obtenerHaberCliente($clicod, $fechaDesde);
    }

    public function obtenerMovimientosVendedor($clicod, $fechaDesde, $fechaHasta)
    {
        return $this->movCtaCteVtaObtenerMovimientosVendedorRepo->obtenerMovimientosVendedor($clicod, $fechaDesde, $fechaHasta);
    } 

    public function obtenerDebeVendedor($clicod, $fechaDesde)
    {
        return $this->movCtaCteVtaObtenerDebeVendedorRepo->obtenerDebeVendedor($clicod, $fechaDesde);
    } 

        public function obtenerHaberVendedor($clicod, $fechaDesde)
    {
        return $this->movCtaCteVtaObtenerHaberVendedorRepo->obtenerHaberVendedor($clicod, $fechaDesde);
    } 
}