<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteCalcularPorcentajesClienteRepository
{
    public function calcularPorcentajeCliente($clicod)
    {
        $result = DB::table('cliente')
            ->join('TipCta', 'cliente.cli_condvta', '=', 'TipCta.tip_codigo')
            ->where('cliente.cli_codigo', $clicod)
            ->select('tip_porcentaje1', 'tip_porcentaje2', 'tip_porcentaje3', 'tip_porcentaje4')
            ->first();

        if ($result) {
            return $result->tip_porcentaje1 + $result->tip_porcentaje2 + $result->tip_porcentaje3 + $result->tip_porcentaje4;
        } else {
            return false;
        }
    }
}