<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloContarArticulosPorCategoriayRubroRepository
{
	public function contarArticulosPorCategoriayRubro($query, $params)
	{
		$sql_cant = "SELECT COUNT(*) AS total FROM Articulo
		LEFT JOIN AdicionalxArtic ON (Articulo.art_codtex = AdicionalxArtic.ada_codtex 
		AND Articulo.art_codnum = AdicionalxArtic.ada_codnum 
		AND AdicionalxArtic.ada_vigencia = 1)
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo)
		WHERE Articulo.art_vigencia = 1 AND art_precmayo <> 0 AND art_precmino <> 0 AND art_carrito = 1 
		$query->tipoProducto $query->rubro
		AND art_preclista >= $params->precioMin AND art_preclista <= $params->precioMax";

		return DB::select($sql_cant);
	}
}