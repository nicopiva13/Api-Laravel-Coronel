<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteObtenerDatosClientePrecioRepository
{
    public function datosCliente($clicod)
    {
        return DB::table('cliente')
            ->select(
                'cli_categoria',
                'cli_formpag',
                'cli_condvta',
                'cli_lisp',
                'Categoria.cat_tipo'
            )
            ->leftJoin('Categoria', 'Cliente.cli_categoria', '=', 'Categoria.cat_codigo')
            ->where('cli_codigo', $clicod)
            ->first();
    }
}