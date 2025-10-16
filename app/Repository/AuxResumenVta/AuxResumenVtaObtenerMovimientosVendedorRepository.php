<?php

namespace App\Repository\AuxResumenVta;

use Illuminate\Support\Facades\DB;

class AuxResumenVtaObtenerMovimientosVendedorRepository
{
    //Esto va en coronel
    // public function obtenerMovimientosVendedor($clicod)
    // {
    //     $movimientos = DB::connection('sqlsrv_vendedor')
    //         ->table('Aux_ResumenVta')
    //         ->where('res_terminal', $clicod)
    //         ->select('res_fecha', 'res_tipmov', 'res_nrocomp', 'res_debe', 'res_haber', 'res_acumulado')
    //         ->get();
    
    //     return $movimientos;
    // }

    public function obtenerMovimientosVendedor($clicod)
    {
        $movimientos = DB::connection('sqlsrv')
            ->table('Aux_ResumenVta')
            ->where('res_terminal', $clicod)
            ->select('res_fecha', 'res_tipmov', 'res_nrocomp', 'res_debe', 'res_haber', 'res_acumulado')
            ->get();
    
        return $movimientos;
    }
}