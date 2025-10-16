<?php

namespace App\Repository\Oferta;

use Illuminate\Support\Facades\DB;

class OfertaContarOfertasRepository
{
	public function contarOfertas($OfeDesde, $OfeHasta, $CAT, $TIPPROD)
	{
		if ($OfeDesde === 'CURRENT_TIMESTAMP') {
			$OfeDesde = now();
		}
		if ($OfeHasta === 'CURRENT_TIMESTAMP') {
			$OfeHasta = now();
		}

		$total = DB::table('Oferta as O')
			->join('Articulo as A', function ($join) {
				$join->on('O.ofe_codtex', '=', 'A.art_codtex')
					->where(function ($query) {
						$query->where('O.ofe_codnum', '=', 0)
							->orWhere('O.ofe_codnum', '=', DB::raw('A.art_codnum'));
					});
			})
			->where('O.ofe_AplicaWeb', 1)
			->whereDate('O.ofe_desde', '<=', $OfeDesde)
			->whereDate('O.ofe_hasta', '>=', $OfeHasta)
			->whereRaw($CAT)
			->when(!empty($TIPPROD), function ($query) use ($TIPPROD) {
				$query->whereRaw($TIPPROD);
			})
			->count('*');

		return $total;
	}
}