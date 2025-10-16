<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteObtenerClientesRepository
{
    public function obtenerClientes($cuit, $dni)
    {
        $query = DB::table('cliente')
            ->leftJoin('Vendedor', 'cliente.cli_vendedor', '=', 'Vendedor.ven_codigo')
            ->leftJoin('localidad', function ($join) {
                $join->on('cliente.cli_codpos1', '=', 'localidad.loc_cod1')
                    ->on('cliente.cli_codpos2', '=', 'localidad.loc_cod2');
            })
            ->where('cli_estado', 1)
            ->select(
                'cli_codigo',
                'cli_nombre',
                'cli_domicilio',
                'cli_telefono',
                'cli_celular',
                'loc_provin AS cli_provin',
                'cli_codpos1',
                'cli_codpos2',
                'cli_email',
                'cli_cuit1',
                'cli_cuit2',
                'cli_cuit3',
                'cli_dni',
                'cli_vendedor',
                'Vendedor.ven_nombre',
                'cli_accesoWeb',
                'cli_habilitadoWeb',
                'cli_categoria'
            );

        if (!empty($cuit)) {
            $query->where('cli_cuit1', substr($cuit, 0, 2))
                ->where('cli_cuit2', substr($cuit, 2, 8))
                ->where('cli_cuit3', substr($cuit, -1));
        }

        if (!empty($dni)) {
            $query->where('cli_dni', $dni);
        }
        return $query->get();
    }
}