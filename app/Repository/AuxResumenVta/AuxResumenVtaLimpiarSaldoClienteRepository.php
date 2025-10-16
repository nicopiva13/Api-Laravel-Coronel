<?php

namespace App\Repository\AuxResumenVta;

use Illuminate\Support\Facades\DB;

class AuxResumenVtaLimpiarSaldoClienteRepository
{
    //Esto va en coronel
    // public function limpiarSaldo($clicod)
    // {
    //     DB::connection('sqlsrv_resumenCliente')
    //     ->table('Aux_ResumenVta')
    //     ->where('res_terminal', $clicod)
    //     ->delete();
    // }

    public function limpiarSaldoCliente($clicod)
    {
        DB::connection('sqlsrv')
        ->table('Aux_ResumenVta')
        ->where('res_terminal', $clicod)
        ->delete();
    }
}
