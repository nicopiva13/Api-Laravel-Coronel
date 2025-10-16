<?php

namespace App\Services\Vendedor;

use App\Repository\Vendedor\VendedorObtenerVendedoresActivosRepository;
use App\Repository\Vendedor\VendedorObtenerClientesDelVendedorRepository;

class VendedorService
{
    protected VendedorObtenerVendedoresActivosRepository $vendedorObtenerVendedoresActivosRepo;
    protected VendedorObtenerClientesDelVendedorRepository $vendedorObtenerClientesDelVendedorRepo;

    public function __construct(
        VendedorObtenerVendedoresActivosRepository $vendedorObtenerVendedoresActivosRepo,
        VendedorObtenerClientesDelVendedorRepository $vendedorObtenerClientesDelVendedorRepo,
    ) {
        $this->vendedorObtenerVendedoresActivosRepo = $vendedorObtenerVendedoresActivosRepo;
        $this->vendedorObtenerClientesDelVendedorRepo = $vendedorObtenerClientesDelVendedorRepo;
    }

    public function obtenerVendedoresActivos()
    {
        return $this->vendedorObtenerVendedoresActivosRepo->obtenerVendedoresActivos();
    }

    public function obtenerClientesDelVendedor($cli_vendedor)
    {
        return $this->vendedorObtenerClientesDelVendedorRepo->obtenerClientesDelVendedor($cli_vendedor);
    }
}