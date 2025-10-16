<?php

namespace App\Services\TipoProducto;

use App\Repository\Transporte\TipoProductoObtenerTiposProductosRepository;

class TipoProductoService
{
    protected TipoProductoObtenerTiposProductosRepository $tipoProductoObtenerTipoProductosRepo;

    public function __construct(
        TipoProductoObtenerTiposProductosRepository $tipoProductoObtenerTipoProductosRepo,
    ) {
        $this->tipoProductoObtenerTipoProductosRepo = $tipoProductoObtenerTipoProductosRepo;
    }

    public function obtenerTiposProducto()
    {
        return $this->tipoProductoObtenerTipoProductosRepo->obtenerTiposProducto();
    }
}