<?php

namespace App\Repository\MovVta;

use Illuminate\Support\Facades\DB;

class MovVtaObtenerMovimientosRepository
{
    public function obtenerMovimientos($codigo)
    {
        return DB::table('MovVta')
            ->join('TipMov', 'MovVta.vta_tipmov', '=', 'TipMov.tmo_codigo')
            ->whereIn('MovVta.vta_tipmov', [1, 6])
            ->where('MovVta.vta_ctacli', $codigo)
            ->select([
                'MovVta.vta_codigo',
                'MovVta.vta_fecemi',
                'MovVta.vta_cpbte',
                'MovVta.vta_estado',
                'MovVta.vta_total',
                'TipMov.tmo_descri as tipoMov'
            ])
            ->get();
    }
}