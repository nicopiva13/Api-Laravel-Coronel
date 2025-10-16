<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteObtenerClienteRepository
{
    public function obtenerCliente($codigo)
    {
        return DB::table('cliente')
            ->select(
                'cli_codigo',
                'cli_nombre',
                'cli_domicilio',
                'cli_telefono',
                'cli_celular',
                'loc_provin',
                'cli_codpos1',
                'cli_codpos2',
                'cli_email',
                'cli_cuit1',
                'cli_cuit2',
                'cli_cuit3',
                'cli_dni',
                'cli_usuario',
                'cli_web',
                'cli_habilitadoWeb',
                'cli_vendedor',
                'loc_nombre',
                'cli_categoria',
                'cat_tipo'
            )
            ->leftJoin('Categoria', 'Cliente.cli_categoria', '=', 'Categoria.cat_codigo')
            ->leftJoin('localidad', function ($join) {
                $join->on('Cliente.cli_codpos1', '=', 'Localidad.loc_cod1')
                    ->on('Cliente.cli_codpos2', '=', 'Localidad.loc_cod2');
            })
            ->where('cli_codigo', $codigo)
            ->first();
    }
}