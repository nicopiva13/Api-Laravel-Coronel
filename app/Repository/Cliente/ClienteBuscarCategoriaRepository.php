<?php

namespace App\Repository\Cliente;

use Illuminate\Support\Facades\DB;

class ClienteBuscarCategoriaRepository
{
    public function buscarCategoria($cli_cod)
    {
        $categoria = DB::table('cliente')
            ->leftJoin('Categoria', 'cliente.cli_categoria', '=', 'Categoria.cat_codigo')
            ->where('cliente.cli_codigo', $cli_cod)
            ->select('Categoria.cat_tipo')
            ->first();
            
        if ($categoria) {
            if ($categoria->cat_tipo == 1) {
                return "art_precmino AS precio";
            } elseif ($categoria->cat_tipo == 2) {
                return "art_precmayo AS precio";
            }
        }
        return false;
    }
}