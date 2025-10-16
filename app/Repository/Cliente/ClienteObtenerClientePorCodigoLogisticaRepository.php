<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteObtenerClientePorCodigoLogisticaRepository
{
    public function obtenerClientePorCodigoLogistica($codigo)
    {
        return DB::table('Cliente')
            ->join('Categoria', 'Cliente.cli_categoria', '=', 'Categoria.cat_codigo')
            ->join('Localidad', function ($join) {
                $join->on('Cliente.cli_codpos1', '=', 'Localidad.loc_cod1')
                    ->on('Cliente.cli_codpos2', '=', 'Localidad.loc_cod2');
            })
            ->where('Cliente.cli_codigo', $codigo)
            ->select('Cliente.*', 'Categoria.*', 'Localidad.*')
            ->first();
    }
}