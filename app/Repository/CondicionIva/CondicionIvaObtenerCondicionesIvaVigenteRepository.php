<?php

namespace App\Repository\CondicionIva;

use Illuminate\Support\Facades\DB;

class CondicionIvaObtenerCondicionesIvaVigenteRepository
{
    public function obtenerCondicionesIvaVigentes()
    {
        return DB::table('CondIva')
            ->select('iva_codigo', 'iva_condicion')
            ->where('iva_estado', 'VIGENTE')
            ->get();
    }
}