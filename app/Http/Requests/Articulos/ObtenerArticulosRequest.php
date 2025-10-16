<?php

namespace App\Http\Requests\Articulos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ObtenerArticulosRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cli_categoria' => 'nullable',
            'Q' => 'nullable',
            'CliCod' => 'nullable',
            'BanderaVen' => 'nullable',
            'T' => 'nullable',
            'R' => 'nullable',
            'L' => 'nullable',
            'F' => 'nullable',
            'CODBAR' => 'nullable',
            'CODFAB' => 'nullable',
            'CODINT' => 'nullable',
            'ORD' => 'nullable',
            'PRICE' => 'nullable',
            'PMIN' => 'nullable',
            'PMAX' => 'nullable',
            'PAGE' => 'nullable',
            'CANT' => 'nullable',
            'TIPOCLIENTE' => 'nullable',
        ];
    }

    public function obtenerParametros(): \stdClass
    {
        $params = new \stdClass();
        $params->cli_categoria = $this->input('cli_categoria');
        $params->busqueda = $this->input('Q', '');
        $params->clicod = $this->input('CliCod', '');
        $params->banderaVendedor = $this->input('BanderaVen', '');
        $params->tipoProducto = $this->input('T', '');
        $params->rubro = $this->input('R', '');
        $params->linea = $this->input('L', '');
        $params->fabrica = $this->input('F', '');
        $params->codbarra = $this->input('CODBAR', '');
        $params->codfab = Str::upper($this->input('CODFAB', ''));
        $params->codinterno = Str::upper($this->input('CODINT', ''));
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