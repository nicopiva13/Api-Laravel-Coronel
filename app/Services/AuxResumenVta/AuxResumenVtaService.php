<?php

namespace App\Services\AuxResumenVta;

use App\Repository\AuxResumenVta\AuxResumenVtaLimpiarSaldoClienteRepository;
use App\Repository\AuxResumenVta\AuxResumenVtaProcesarMovimientosClienteRepository;
use App\Repository\AuxResumenVta\AuxResumenVtaObtenerMovimientosClienteRepository;
use App\Repository\AuxResumenVta\AuxResumenVtaLimpiarSaldoVendedorRepository;
use App\Repository\AuxResumenVta\AuxResumenVtaProcesarMovimientosVendedorRepository;
use App\Repository\AuxResumenVta\AuxResumenVtaObtenerMovimientosVendedorRepository;

class AuxResumenVtaService
{
    protected AuxResumenVtaLimpiarSaldoClienteRepository $auxResumenVtaLimpiarSaldoClienteRepo;
    protected AuxResumenVtaProcesarMovimientosClienteRepository $auxResumenVtaProcesarMovimientosClienteRepo;
    protected AuxResumenVtaObtenerMovimientosClienteRepository $auxResumenVtaObtenerMovimientosClienteRepo;
    protected AuxResumenVtaLimpiarSaldoVendedorRepository $auxResumenVtaLimpiarSaldoVendedorRepo;
    protected AuxResumenVtaProcesarMovimientosVendedorRepository $auxResumenVtaProcesarMovimientosVendedorRepo;
    protected AuxResumenVtaObtenerMovimientosVendedorRepository $auxResumenVtaObtenerMovimientosVendedorRepo;

    public function __construct(
        AuxResumenVtaLimpiarSaldoClienteRepository $auxResumenVtaLimpiarSaldoClienteRepo,
        AuxResumenVtaProcesarMovimientosClienteRepository $auxResumenVtaProcesarMovimientosClienteRepo,
        AuxResumenVtaObtenerMovimientosClienteRepository $auxResumenVtaObtenerMovimientosClienteRepo,
        AuxResumenVtaLimpiarSaldoVendedorRepository $auxResumenVtaLimpiarSaldoVendedorRepo,
        AuxResumenVtaProcesarMovimientosVendedorRepository $auxResumenVtaProcesarMovimientosVendedorRepo,
        AuxResumenVtaObtenerMovimientosVendedorRepository $auxResumenVtaObtenerMovimientosVendedorRepo,
    ) {
        $this->auxResumenVtaLimpiarSaldoClienteRepo = $auxResumenVtaLimpiarSaldoClienteRepo;
        $this->auxResumenVtaProcesarMovimientosClienteRepo = $auxResumenVtaProcesarMovimientosClienteRepo;
        $this->auxResumenVtaObtenerMovimientosClienteRepo = $auxResumenVtaObtenerMovimientosClienteRepo;
        $this->auxResumenVtaLimpiarSaldoVendedorRepo = $auxResumenVtaLimpiarSaldoVendedorRepo;
        $this->auxResumenVtaProcesarMovimientosVendedorRepo = $auxResumenVtaProcesarMovimientosVendedorRepo;
        $this->auxResumenVtaObtenerMovimientosVendedorRepo = $auxResumenVtaObtenerMovimientosVendedorRepo;
    }

    public function limpiarSaldoCliente($clicod)
    {
        return $this->auxResumenVtaLimpiarSaldoClienteRepo->limpiarSaldoCliente($clicod);
    }

    public function procesarMovimientosCliente($resultado1, $clicod, $saldoInicia)
    {
        return $this->auxResumenVtaProcesarMovimientosClienteRepo->procesarMovimientosCliente($resultado1, $clicod, $saldoInicia);
    }

    public function obtenerMovimientosClientes($clicod)
    {
        return $this->auxResumenVtaObtenerMovimientosClienteRepo->obtenerMovimientosClientes($clicod);
    }

    public function limpiarSaldoVendedor($clicod)
    {
        return $this->auxResumenVtaLimpiarSaldoVendedorRepo->limpiarSaldoVendedor($clicod);
    } 

    public function procesarMovimientosVendedor($resultado1, $clicod, $saldoInicial)
    {
        return $this->auxResumenVtaProcesarMovimientosVendedorRepo->procesarMovimientosVendedor($resultado1, $clicod, $saldoInicial);
    } 

    public function obtenerMovimientosVendedor($clicod)
    {
        return $this->auxResumenVtaObtenerMovimientosVendedorRepo->obtenerMovimientosVendedor($clicod);
    } 
}