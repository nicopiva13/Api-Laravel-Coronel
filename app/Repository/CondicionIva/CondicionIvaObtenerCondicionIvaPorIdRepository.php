<?php

namespace App\Repository\CondicionIva;

use Illuminate\Support\Facades\DB;

class CondicionIvaObtenerCondicionIvaPorIdRepository
{
    public function obtenerCondicionIvaPorId($id)
    {
        return DB::table('CondIva')
            ->select('iva_condicion')
            ->where('iva_codigo', $id)
            ->get();
    }
}