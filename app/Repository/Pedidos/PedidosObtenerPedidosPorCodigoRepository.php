<?php

namespace App\Repository\Pedidos;

use Illuminate\Support\Facades\DB;

class PedidosObtenerPedidosPorCodigoRepository
{
    //Va en la posta
    // public function obtenerPedidosPorCodigogetPedidosByCodigo($codigo, $fecha)
    // {
    //     return DB::connection('sqlsrv_resumenCliente')
    //         ->table('movVtaPed')
    //         ->join('Vendedor', 'movVtaPed.vta_vendedor', '=', 'Vendedor.ven_codigo')
    //         ->where('vta_ctacli', $codigo)
    //         ->where('vta_fecpro', '>=', $fecha)
    //         ->select(
    //             'vta_fecpro',
    //             'vta_vendedor',
    //             'Vendedor.ven_nombre as ven_nombre',
    //             'vta_total',
    //             'vta_estado'
    //         )
    //         ->orderBy('vta_fecpro', 'desc')
    //         ->get();
    // }

    public function obtenerPedidosPorCodigo($codigo, $fecha)
    {
        return DB::connection('sqlsrv')
            ->table('movVtaPed')
            ->join('Vendedor', 'movVtaPed.vta_vendedor', '=', 'Vendedor.ven_codigo')
            ->where('vta_ctacli', $codigo)
            ->where('vta_fecpro', '>=', $fecha)
            ->select(
                'vta_fecpro',
                'vta_vendedor',
                'Vendedor.ven_nombre as ven_nombre',
                'vta_total',
                'vta_estado'
            )
            ->orderBy('vta_fecpro', 'desc')
            ->get();
    }
}