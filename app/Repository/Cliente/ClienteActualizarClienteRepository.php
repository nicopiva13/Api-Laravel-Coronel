<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteActualizarClienteRepository
{
    public function actualizarCliente($id, $datos)
    {
        $datos = array_filter($datos);
        if (empty($datos)) {
            return false;
        }

        $datos['cli_fechaRegistro'] = now()->format('Y-m-d');
        $datos['cli_accesoWeb'] = 1;

        return DB::table('cliente')
            ->where('cli_codigo', $id)
            ->update($datos);
    }
}
