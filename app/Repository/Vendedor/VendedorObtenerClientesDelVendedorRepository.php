<?php

namespace App\Repository\Vendedor;

use Illuminate\Support\Facades\DB;

class VendedorObtenerClientesDelVendedorRepository
{
    public function obtenerClientesDelVendedor($cli_vendedor)
    {
        return DB::table('Cliente')
            ->select(
                'Cliente.cli_codigo',
                'Cliente.cli_nombre',
                'Cliente.cli_domicilio',
                'Cliente.cli_codpos1',
                'Cliente.cli_telefono',
                'CondIva.iva_condicion',
                DB::raw("CONCAT(cli_cuit1, cli_cuit2, cli_cuit3) AS cli_cuit"),
                'Cliente.cli_ingbru',
                'Localidad.loc_nombre',
                'Provincia.pro_descri'
            )
            ->leftJoin('CondIva', 'CondIva.iva_codigo', '=', 'Cliente.cli_iva')
            ->leftJoin('Localidad', function ($join) {
                $join->on('Localidad.loc_cod1', '=', 'Cliente.cli_codpos1')
                     ->on('Localidad.loc_cod2', '=', 'Cliente.cli_codpos2');
            })
            ->leftJoin('Provincia', 'Provincia.pro_codigo', '=', 'Localidad.loc_provin')
            ->where('Cliente.cli_vendedor', $cli_vendedor)
            ->where('Cliente.cli_estado', 1)
            ->orderBy('Cliente.cli_codigo', 'asc')
            ->get();
    }
}