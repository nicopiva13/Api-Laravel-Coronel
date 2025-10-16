<?php

namespace App\Repository\TipCta;

use Illuminate\Support\Facades\DB;

class TipCtaObtenerCondicionesDeVentasActivasRepository
{
    public function obtenerCondicionesVentaActivas()
    {
        return DB::table('TipCta')
            ->select('tip_codigo', 'tip_descri')
            ->where('tip_vigencia', 1)
            ->orderBy('tip_descri', 'asc')
            ->get();
    }
}