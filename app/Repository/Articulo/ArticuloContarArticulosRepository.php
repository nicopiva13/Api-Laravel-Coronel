<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloContarArticulosRepository
{
    public function contarArticulos($query, $params, $busquedas)
	{
		$sql_cant = "SELECT COUNT(*) AS total FROM Articulo
		LEFT JOIN AdicionalxArtic ON (Articulo.art_codtex = AdicionalxArtic.ada_codtex 
		AND Articulo.art_codnum = AdicionalxArtic.ada_codnum 
		AND AdicionalxArtic.ada_vigencia = 1)
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo)
		WHERE Articulo.art_vigencia = 1 AND art_precmayo <> 0 AND art_precmino <> 0 AND art_carrito = 1 
		$busquedas->Q $query->tipoProducto $query->rubro $query->linea $query->fabrica $query->codbarra $query->codfab $query->codinterno
		AND art_preclista >= $params->precioMin AND art_preclista <= $params->precioMax";

		return DB::select($sql_cant);
	}

	public function contarArticulosPrimerBusqueda($query, $params, $busquedas)
	{
		$sql_cant = "SELECT COUNT(*) AS total FROM Articulo
		LEFT JOIN AdicionalxArtic ON (Articulo.art_codtex = AdicionalxArtic.ada_codtex 
		AND Articulo.art_codnum = AdicionalxArtic.ada_codnum 
		AND AdicionalxArtic.ada_vigencia = 1)
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo)
		LEFT JOIN RubxLineaxFabrica ON (Articulo.art_codtex = RubxLineaxFabrica.rlf_fabrica 
		AND art_linea = rlf_linea 
		AND art_rubro = rlf_rubro)
		LEFT JOIN Fabrica ON (fab_codigo = art_codtex)
		LEFT JOIN TipProd ON (tpp_codigo = art_tipprod)
		LEFT JOIN Rubro ON (rub_codigo = art_rubro)
		WHERE Articulo.art_vigencia = 1 AND art_precmayo <> 0 AND art_precmino <> 0 AND art_carrito = 1
		AND art_preclista >= $params->precioMin AND art_preclista <= $params->precioMax $query->tipoProducto $query->rubro $query->linea $query->fabrica $query->codbarra $query->codfab $query->codinterno
		$busquedas->Q_extra";

		return DB::select($sql_cant);
	}

	public function contarArticulosSegundaBusqueda($query, $params, $busquedas)
	{
		$sql_cant = "SELECT COUNT(*) AS total FROM Articulo
			LEFT JOIN AdicionalxArtic ON (Articulo.art_codtex = AdicionalxArtic.ada_codtex 
			AND Articulo.art_codnum = AdicionalxArtic.ada_codnum 
			AND AdicionalxArtic.ada_vigencia = 1)
			LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo)
			LEFT JOIN RubxLineaxFabrica ON (Articulo.art_codtex = RubxLineaxFabrica.rlf_fabrica 
			AND art_linea = rlf_linea 
			AND art_rubro = rlf_rubro)
			LEFT JOIN Fabrica ON (fab_codigo = art_codtex)
			LEFT JOIN TipProd ON (tpp_codigo = art_tipprod)
			LEFT JOIN Rubro ON (rub_codigo = art_rubro)
			WHERE Articulo.art_vigencia = 1 AND art_precmayo <> 0 AND art_precmino <> 0 AND art_carrito = 1 $query->tipoProducto $query->rubro $query->linea $query->fabrica $query->codbarra $query->codfab $query->codinterno
			AND art_preclista >= $params->precioMin AND art_preclista <= $params->precioMax
			$busquedas->Q_extraPalabras";

		return DB::select($sql_cant);
	}

	public function contarArticulosTerceraBusqueda($query, $params, $busquedas)
	{
		$sql_cant = "SELECT COUNT(*) AS total FROM Articulo
			LEFT JOIN AdicionalxArtic ON (Articulo.art_codtex = AdicionalxArtic.ada_codtex 
			AND Articulo.art_codnum = AdicionalxArtic.ada_codnum 
			AND AdicionalxArtic.ada_vigencia = 1)
			LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo)
			LEFT JOIN RubxLineaxFabrica ON (Articulo.art_codtex = RubxLineaxFabrica.rlf_fabrica 
			AND art_linea = rlf_linea 
			AND art_rubro = rlf_rubro)
			LEFT JOIN Fabrica ON (fab_codigo = art_codtex)
			LEFT JOIN TipProd ON (tpp_codigo = art_tipprod)
			LEFT JOIN Rubro ON (rub_codigo = art_rubro)
			WHERE Articulo.art_vigencia = 1 AND art_precmayo <> 0 AND art_precmino <> 0 AND art_carrito = 1 $query->tipoProducto $query->rubro $query->linea $query->fabrica $query->codbarra $query->codfab $query->codinterno
			AND art_preclista >= $params->precioMin AND art_preclista <= $params->precioMax
			$busquedas->Q_extraSubstring";

		return DB::select($sql_cant);
	}
}