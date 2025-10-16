<?php

namespace App\Repository\Oferta;

use Illuminate\Support\Facades\DB;

class OfertaObtenerCategoriasOfertasRepository
{
	public function obtenerCategoriasOferta($categ)
	{
		return DB::table('oferta')
			->leftJoin('cliente', 'cliente.cli_categoria', '=', 'oferta.ofe_categoria')
			->leftJoin('articulo', function ($join) {
				$join->on('articulo.art_codnum', '=', 'oferta.ofe_codnum')
					->orOn('articulo.art_codtex', '=', 'oferta.ofe_codtex');
			})
			->leftJoin('tipprod', 'articulo.art_tipprod', '=', 'tipprod.tpp_codigo')
			->select('tipprod.tpp_descri', 'tipprod.tpp_codigo')
			->where('articulo.art_vigencia', 1)
			->where('articulo.art_carrito', 1)
			->where(function ($query) {
				$query->where('articulo.art_ctrlMinoWEB', 1)
					->orWhere('articulo.art_ctrlMayoWEB', 1);
			})
			->where('cliente.cli_categoria', $categ)
			->where('oferta.ofe_AplicaWEB', 1)
			->groupBy('tipprod.tpp_descri', 'tipprod.tpp_codigo')
			->orderBy('tipprod.tpp_descri', 'ASC')
			->get();
	}
}