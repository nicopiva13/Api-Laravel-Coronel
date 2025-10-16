<?php

namespace App\Http\Requests\Articulos;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerArticulosPorCategoriaYRubroRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cli_categoria' => 'nullable|string',
            'CliCod' => 'nullable|string',
            'BanderaVen' => 'nullable|string',
            'T' => 'nullable|string',
            'R' => 'nullable|string',
            'ORD' => 'nullable|in:ASC,DESC',
            'PRICE' => 'nullable|in:ASC,DESC',
            'PMIN' => 'nullable|numeric|min:0',
            'PMAX' => 'nullable|numeric|min:0',
            'PAGE' => 'nullable|integer|min:1',
            'CANT' => 'nullable|integer|min:1',
            'TIPOCLIENTE' => 'nullable|integer|in:1,2',
        ];
    }

    public function obtenerParametros(): \stdClass
    {
        $params = new \stdClass();
        $params->cli_categoria = $this->input('cli_categoria');
        $params->clicod = $this->input('CliCod', '');
        $params->banderaVendedor = $this->input('BanderaVen', '');
        $params->tipoProducto = $this->input('T', '');
        $params->rubro = $this->input('R', '');
        $params->orden = $this->input('ORD', '');
        $params->precio = $this->input('PRICE', '');
        $params->precioMin = (float) $this->input('PMIN', 0);
        $params->precioMax = (float) $this->input('PMAX', 100000000);
        return $params;
    }

    public function obtenerPaginacion(): \stdClass
    {
        $paginacion = new \stdClass();
        $paginacion->page = max(1, (int) $this->input('PAGE', 1));
        $paginacion->limit = max(1, (int) $this->input('CANT', 30));
        $paginacion->min = (($paginacion->page - 1) * $paginacion->limit) + 1;
        $paginacion->max = $paginacion->page * $paginacion->limit;
        return $paginacion;
    }

    public function obtenerPrecioCliente(): string
    {
        return match ((int) $this->input('TIPOCLIENTE', 2)) {
            1 => 'art_precmino as art_preclista',
            default => 'art_precmayo as art_preclista',
        };
    }

    public function obtenerOrdenamiento(\stdClass $params): string
    {
        return match (true) {
            !empty($params->orden) && empty($params->precio) => "ORDER BY art_descri " . $params->orden,
            empty($params->orden) && !empty($params->precio) => "ORDER BY art_preclista " . $params->precio,
            default => "ORDER BY art_descri ASC",
        };
    }
}
