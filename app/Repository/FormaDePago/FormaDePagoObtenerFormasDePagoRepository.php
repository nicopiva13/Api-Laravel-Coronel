<?php

namespace App\Repository\FormaDePago;

use Illuminate\Support\Facades\DB;

class FormaDePagoObtenerFormasDePagoRepository
{
    public function obtenerFormasDePago()
    {
        return DB::table('FormPag')
            ->orderBy('for_descri', 'asc')
            ->get(['for_codigo', 'for_descri']);
    }
}