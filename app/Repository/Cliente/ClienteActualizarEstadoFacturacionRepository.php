<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteActualizarEstadoFacturacionRepository
{
    public function actualizarEstadoFacturacion($cli_codigo, $nuevoEstado)
    {
        return DB::table('cliente')
            ->where('cli_codigo', $cli_codigo)
            ->update(['cli_FERecibeMail' => $nuevoEstado]);
    }
}
