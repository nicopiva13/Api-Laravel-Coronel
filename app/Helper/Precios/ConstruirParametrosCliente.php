<?php

namespace App\Helper\Precios;

class ConstruirParametrosCliente
{
    public function construirParametrosCliente(object $cliente, object $datos, object $parametros): object
    {
        return (object) [
            'categoria'     => in_array($cliente->cat_tipo, [1, 2]) ? $cliente->cli_categoria : $parametros->par_categoria,
            'categoriaTipo' => in_array($cliente->cat_tipo, [1, 2]) ? $cliente->cat_tipo : 0,
            'condvta'       => $datos->condvta ?: ($cliente->cli_condvta ?? $parametros->par_condvta),
            'formpag'       => $datos->formpag ?: ($cliente->cli_formpag ?? $parametros->par_formpago),
            'listac'        => $cliente->cli_lisp ?? $parametros->par_listaporc,
        ];
    }

    // private function obtenerParametrosCliente($cliente, $datos, $parametros)
    // {
    //     $parametrosCliente = new \stdClass();

    //     $parametrosCliente->categoria = in_array($cliente->cat_tipo, [1, 2]) ? $cliente->cli_categoria : $parametros->par_categoria;
    //     $parametrosCliente->categoriaTipo = in_array($cliente->cat_tipo, [1, 2]) ? $cliente->cat_tipo : 0;
    //     $parametrosCliente->condvta = $datos->condvta ?: ($cliente->cli_condvta ?? $parametros->par_condvta);
    //     $parametrosCliente->formpag = $datos->formpag ?: ($cliente->cli_formpag ?? $parametros->par_formpago);
    //     $parametrosCliente->listac = $cliente->cli_lisp ?? $parametros->par_listaporc;

    //     return $parametrosCliente;
    // }
}