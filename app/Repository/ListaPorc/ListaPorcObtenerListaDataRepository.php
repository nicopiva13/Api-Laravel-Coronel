<?php

namespace App\Repository\ListaPorc;

use Illuminate\Support\Facades\DB;

class ListaPorcObtenerListaDataRepository
{
    public function obtenerListaData($listac, $listaPDefParam, $listapd)
    {
        if (intval($listac) > 0) {
            $lista = DB::table('listaporc')
                ->select('lis_vigencia')
                ->where('lis_codigo', $listac)
                ->first();

            if ($lista) {
                $codigoLista = (intval($lista->lis_vigencia) === 0) ? $listaPDefParam : $listac;

                return DB::table('listaporc')
                    ->select('lis_porc1', 'lis_porc2', 'lis_porc3', 'lis_porc4', 'lis_base')
                    ->where('lis_codigo', $codigoLista)
                    ->first();
            }
        } else {
            session(['lista' => $listapd]);
            return DB::table('listaporc')
                ->select('lis_porc1', 'lis_porc2', 'lis_porc3', 'lis_porc4', 'lis_base')
                ->where('lis_codigo', $listapd)
                ->first();
        }

        return null;
    }
}
