<?php

namespace App\Repository\PreArt;

use Illuminate\Support\Facades\DB;

class PreArtObtenerDescuentosUsuarioRepository
{
    public function obtenerDescuentos($clicod, $fabrica, $condvta, $articulo, $linea, $rubro, $cantidad)
    {
        return DB::table('preart')
            ->select('pra_dto1', 'pra_dto2', 'pra_dto3', 'pra_dto4', 'pra_dto5', 'pra_dto6', 'pra_secuencia')
            ->where('pra_ctacli', $clicod)
            ->where('pra_fabrica', $fabrica)
            ->where(function ($q) use ($condvta) {
                $q->whereNull('pra_tipcta')
                  ->orWhere('pra_tipcta', $condvta);
            })
            ->where(function ($q) use ($articulo, $linea, $rubro, $cantidad) {
                $q->orWhere(function ($sub) use ($articulo, $cantidad) {
                    $sub->where('pra_secuencia', 4)
                        ->where('pra_articulo', $articulo)
                        ->whereRaw($cantidad . ' >= pra_cant');
                })
                ->orWhere(function ($sub) use ($linea, $rubro) {
                    $sub->where('pra_secuencia', 3)
                        ->where('pra_linea', $linea)
                        ->where('pra_rubro', $rubro);
                })
                ->orWhere(function ($sub) use ($linea) {
                    $sub->where('pra_secuencia', 2)
                        ->where('pra_linea', $linea);
                })
                ->orWhere(function ($sub) {
                    $sub->where('pra_secuencia', 1)
                        ->where('pra_linea', 0)
                        ->where('pra_rubro', 0);
                })
                ->orWhere(function ($sub) {
                    $sub->where('pra_secuencia', 5)
                        ->where('pra_articulo', 0)
                        ->where('pra_linea', 0)
                        ->where('pra_rubro', 0);
                });
            })
            ->orderByDesc('pra_secuencia')
            ->limit(1)
            ->first();
    }
}