<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteObtenerEstadoFacturacionRepository
{
    public function obtenerEstadoFacturacion($cli_codigo)
    {
        return DB::table('Cliente')
            ->where('cli_codigo', $cli_codigo)
            ->value('cli_FERecibeMail');
    }
}