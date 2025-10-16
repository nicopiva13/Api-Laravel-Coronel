<?php

namespace App\Repository\AuxResumenVta;

use Illuminate\Support\Facades\DB;

class AuxResumenVtaLimpiarSaldoVendedorRepository
{
    //Esto va en coronel
    // public function limpiarSaldoVendedor($clicod)
    // {
    //     DB::connection('sqlsrv_vendedor')
    //         ->table('Aux_ResumenVta')
    //         ->where('res_terminal', $clicod)
    //         ->delete();
    // }

    public function limpiarSaldoVendedor($clicod)
    {
        DB::connection('sqlsrv')
            ->table('Aux_ResumenVta')
            ->where('res_terminal', $clicod)
            ->delete();
    }
}