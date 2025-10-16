<?php

namespace App\Repository\AuxResumenVta;

use Illuminate\Support\Facades\DB;

class AuxResumenVtaObtenerMovimientosClienteRepository
{
    //Esto va en coronel
    // public function obtenerMovimientos($clicod)
    // {
    //     $movimientos = DB::connection('sqlsrv_resumenCliente')
    //         ->table('Aux_ResumenVta')
    //         ->where('res_terminal', $clicod)
    //         ->select('res_fecha', 'res_tipmov', 'res_nrocomp', 'res_debe', 'res_haber', 'res_acumulado')
    //         ->get();
    
    //     return $movimientos;
    // }    

    public function obtenerMovimientosClientes($clicod)
    {
        $movimientos = DB::connection('sqlsrv')
            ->table('Aux_ResumenVta')
            ->where('res_terminal', $clicod)
            ->select('res_fecha', 'res_tipmov', 'res_nrocomp', 'res_debe', 'res_haber', 'res_acumulado')
            ->get();
    
        return $movimientos;
    }
}