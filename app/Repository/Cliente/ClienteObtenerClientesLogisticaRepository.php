<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteObtenerClientesLogisticaRepository
{
    public function obtenerClientesLogistica($provincia)
    {
        $clientes = DB::table('Cliente as c')
            ->leftJoin('Localidad as l', function ($join) {
                $join->on('c.cli_codpos1', '=', 'l.loc_cod1')
                    ->on('c.cli_codpos2', '=', 'l.loc_cod2');
            })
            ->leftJoin('Provincia as p', 'l.loc_provin', '=', 'p.pro_codigo')
            ->leftJoin('Vendedor as v', 'c.cli_vendedor', '=', 'v.ven_codigo')
            ->select(
                'c.cli_codigo',
                'c.cli_nombre',
                'c.cli_domicilio',
                'c.cli_telefono',
                'c.cli_celular',
                'l.loc_provin as cli_provin',
                'l.loc_nombre as localidad',
                'p.pro_descri as provincia',
                'c.cli_codpos1',
                'c.cli_email',
                'c.cli_dni',
                'c.cli_vendedor',
                'v.ven_nombre',
                'c.cli_accesoWeb',
                'c.cli_habilitadoWeb'
            )
            ->where('c.cli_estado', 1)
            ->when($provincia, function ($query) use ($provincia) {
                return $query->where('c.cli_provin', $provincia);
            })
            ->limit(10)
            ->get();

        return $clientes->map(function ($cliente) {
            return [
                'cli_codigo' => $cliente->cli_codigo,
                'cli_nombre' => $cliente->cli_nombre,
                'cli_domicilio' => $cliente->cli_domicilio,
                'cli_telefono' => $cliente->cli_telefono,
                'cli_celular' => $cliente->cli_celular,
                'cli_provin' => $cliente->cli_provin,
                'localidad' => $cliente->localidad ?? null,
                'provincia' => $cliente->provincia ?? null,
                'cli_codpos1' => $cliente->cli_codpos1,
                'cli_email' => $cliente->cli_email,
                'cli_dni' => $cliente->cli_dni,
                'cli_vendedor' => $cliente->cli_vendedor,
                'ven_nombre' => $cliente->ven_nombre ?? null,
                'cli_accesoWeb' => $cliente->cli_accesoWeb,
                'cli_habilitadoWeb' => $cliente->cli_habilitadoWeb,
            ];
        });
    }
}