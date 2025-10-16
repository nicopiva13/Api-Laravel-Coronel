<?php

namespace App\Repository\TipCta;

use Illuminate\Support\Facades\DB;

class TipCtaObtenerDescuentosRepository
{
    public function obtenerDescuentos($condvta, $formpag)
    {
        $result = DB::table('tipcta')
            ->select('tip_porcentaje1', 'tip_porcentaje2', 'tip_porcentaje3', 'tip_porcentaje4', 'tip_porc1')
            ->where('tip_codigo', $condvta)
            ->first();

        if ($result) {
            $desa = $result->tip_porcentaje1;
            $desb = $result->tip_porcentaje2;
            $desc = $result->tip_porcentaje3;
            $desd = $result->tip_porcentaje4;

            $descto = $formpag != 2 ? $result->tip_porc1 : null;

            return [
                'desa'  => $desa,
                'desb'  => $desb,
                'desc'  => $desc,
                'desd'  => $desd,
                'descto' => $descto
            ];
        } else {
            return null;
        }
    }
}