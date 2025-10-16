<?php

namespace App\Repository\Vendedor;

use Illuminate\Support\Facades\DB;

class VendedorObtenerVendedoresActivosRepository
{
    public function obtenerVendedoresActivos()
    {
        return DB::table('vendedor')
            ->where('ven_estado', 1)
            ->select(
                'ven_codigo',
                'ven_nombre',
                'ven_codpos1',
                'ven_codpos2',
                'ven_email',
                'ven_fecing',
                'ven_cuit1',
                'ven_cuit2',
                'ven_cuit3',
                'ven_categoria',
                'ven_estado'
            )
            ->get();
    }
}