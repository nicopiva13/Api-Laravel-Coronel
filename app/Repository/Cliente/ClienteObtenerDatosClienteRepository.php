<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteObtenerDatosClienteRepository
{
    public function obtenerDatosCliente($numCliente)
    {
        return DB::table('Cliente')
            ->select(
                'Cliente.cli_codigo',
                'Cliente.cli_nombre',
                'Cliente.cli_domicilio',
                'Cliente.cli_codpos1',
                'Cliente.cli_telefono',
                'CondIva.iva_condicion',
                DB::raw("ISNULL(Cliente.cli_cuit1, '') + ISNULL(Cliente.cli_cuit2, '') + ISNULL(Cliente.cli_cuit3, '') AS cli_cuit"),
                'Cliente.cli_ingbru',
                'Localidad.loc_nombre',
                'Provincia.pro_descri'
            )
            ->leftJoin('CondIva', 'CondIva.iva_codigo', '=', 'Cliente.cli_iva')
            ->leftJoin('Localidad', function ($join) {
                $join->on('Cliente.cli_codpos1', '=', 'Localidad.loc_cod1')
                     ->on('Cliente.cli_codpos2', '=', 'Localidad.loc_cod2');
            })
            ->leftJoin('Provincia', 'Localidad.loc_provin', '=', 'Provincia.pro_codigo')
            ->where('Cliente.cli_codigo', $numCliente)
            ->first();
    }
}
