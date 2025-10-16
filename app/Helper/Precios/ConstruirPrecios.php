<?php

namespace App\Helper\Precios;

class ConstruirPrecios
{
    public function construirPrecios(string $base, array $porcentajes): string
    {
        $expr = $base;

        foreach ($porcentajes as $porc) {
            if ($porc > 0) {
                $expr .= " * (1 + ($porc / 100.0))";
            } elseif ($porc < 0) {
                $expr .= " / (1 + (abs($porc) / 100.0))";
            }
        }

        return $expr;
    }
}