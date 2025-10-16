<?php

namespace App\Services\Pedidos;

use App\Repository\Pedidos\PedidosObtenerPedidosPorCodigoRepository;

class PedidosService
{
    protected PedidosObtenerPedidosPorCodigoRepository $pedidosObtenerPedidosPorCodigoRepo;

    public function __construct(
        PedidosObtenerPedidosPorCodigoRepository $pedidosObtenerPedidosPorCodigoRepo,
    ) {
        $this->pedidosObtenerPedidosPorCodigoRepo = $pedidosObtenerPedidosPorCodigoRepo;
    }

    public function obtenerPedidosPorCodigo($codigo, $fecha)
    {
        return $this->pedidosObtenerPedidosPorCodigoRepo->obtenerPedidosPorCodigo($codigo, $fecha);
    }    
}