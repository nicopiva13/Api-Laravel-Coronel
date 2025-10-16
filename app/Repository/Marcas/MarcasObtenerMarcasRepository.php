<?php

namespace App\Repository\Marcas;

use Illuminate\Support\Facades\DB;

class MarcasObtenerMarcasRepository
{
    public function obtenerMarcas($params)
    {
        $ORD = $params['ORD'] ?? 'fabrica.fab_descri ASC';

        $query = DB::table('articulo')
            ->select('art_codtex as id', 'fabrica.fab_descri as nombre', DB::raw('COUNT(*) as total'))
            ->leftJoin('fabrica', 'articulo.art_codtex', '=', 'fabrica.fab_codigo')
            ->where('articulo.art_vigencia', 1);

        $filterColumns = [
            'T' => 'art_tipprod',
            'R' => 'art_rubro',
            'L' => 'art_linea',
            'F' => 'art_codtex'
        ];

        foreach ($filterColumns as $filter => $column) {
            if (!empty($params[$filter])) {
                $query->where($column, $params[$filter]);
            }
        }

        if ($ORD === 'CAN') {
            $query->orderBy('total', 'DESC');
        } else {
            $query->orderBy('fabrica.fab_descri', 'ASC');
        }

        return $query->groupBy('fabrica.fab_descri', 'art_codtex')
            ->get();
    }
}