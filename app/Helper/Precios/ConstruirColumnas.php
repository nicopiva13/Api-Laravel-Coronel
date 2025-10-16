<?php

namespace App\Helper\Precios;

class ConstruirColumnas
{
    public function obtenerColumnas(int $nlista): ?string
    {
        $names = [
            0 => 'art_preccosto',
            1 => 'art_cn',
            2 => 'art_precventa',
            3 => 'art_precmino',
            4 => 'art_precmayo',
        ];

        return $names[$nlista] ?? null;
    }

    
    // private function obtenerColumnas($nlista)
    // {
    //     $names = [
    //         0 => 'art_preccosto',
    //         1 => 'art_cn',
    //         2 => 'art_precventa',
    //         3 => 'art_precmino',
    //         4 => 'art_precmayo'
    //     ];

    //     return array_key_exists($nlista, $names) ? $names[$nlista] : null;
    // }
}
