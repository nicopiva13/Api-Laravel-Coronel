<?php

namespace App\Repository\Oferta;

use Illuminate\Support\Facades\DB;

class OfertaObtenerOfertaPrecioRepository
{
    public function obtenerOfertaPrecio($categoria, $fabrica, $articulo, $cantidad, $linea, $rubro, $vendedor)
	{
		return DB::table('oferta')
			->select('ofe_dto1', 'ofe_dto2', 'ofe_dto3', 'ofe_dto4', 'ofe_dto5', 'ofe_dto6', 'ofe_secuencia')
			->where('ofe_categoria', $categoria)
			->whereRaw("ofe_codtex = ?", ["$fabrica"])
			->where(function ($query) use ($articulo, $cantidad, $linea, $rubro) {
				$query->where(function ($q) use ($articulo, $cantidad) {
					$q->where('ofe_codnum', $articulo)
						->where('ofe_secuencia', 4)
						->where('ofe_minimo', '<=', $cantidad);
				})
					->orWhere(function ($q) use ($linea, $rubro) {
						$q->whereRaw("ofe_linea = ? AND ofe_rubro = ?", ["$linea", "$rubro"])
							->where('ofe_secuencia', 3);
					})
					->orWhere(function ($q) use ($linea) {
						$q->whereRaw("ofe_linea = ?", ["$linea"])
							->where('ofe_secuencia', 2);
					})
					->orWhere('ofe_secuencia', 1);
			})
			->whereRaw('ofe_desde <= SYSDATETIME()')
			->whereRaw('ofe_hasta >= SYSDATETIME()')
			->whereRaw('ISNULL(ofe_AplicaWEB, 0) = 1')
			->where(function ($query) use ($vendedor) {
				$query->whereNull('ofe_vendedor')
					->orWhere('ofe_vendedor', $vendedor);
			})
			->orderByDesc('ofe_secuencia')
			->first();
	}
}