<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteObtenerCondicionClienteRepository
{
    public function obtenerCondicionCliente($cli_codigo)
    {
        return DB::table('Cliente')
            ->join('TipCta', 'Cliente.cli_condvta', '=', 'TipCta.tip_codigo')
            ->join('FormPag', 'Cliente.cli_formpag', '=', 'FormPag.for_codigo')
            ->select(
                'Cliente.cli_condvta', 
                'TipCta.tip_descri', 
                'Cliente.cli_formpag', 
                'FormPag.for_descri'
            )
            ->where('Cliente.cli_codigo', $cli_codigo)
            ->get();
    }
}