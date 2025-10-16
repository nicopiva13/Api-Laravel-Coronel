<?php

namespace App\Http\Requests\Oferta;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerOfertasRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'PAGE' => 'nullable',
            'CANT' => 'nullable',
            'cat_tipo' => 'nullable',
            'BanderaVen' => 'nullable',
            'FROM' => 'nullable',
            'TO' => 'nullable',
            'TIPPROD' => 'nullable',
            'OFE_CATEGORIA' => 'nullable',
            'CLICOD' => 'nullable',
        ];
    }

    public function obtenerParametrosOferta()
    {
        return (object) [
            'page' => (int) $this->input('PAGE', 1),
            'limit' => (int) $this->input('CANT', 1000),
            'catTipo' => (int) $this->input('cat_tipo', 2),
            'banderaVendedor' => (int) $this->input('BanderaVen', 0),
            'OfeDesde' => $this->input('FROM', 'CURRENT_TIMESTAMP'),
            'OfeHasta' => $this->input('TO', 'CURRENT_TIMESTAMP'),
            'tipProd' => $this->input('TIPPROD', ''),
            'ofeCategoria' => (int) $this->input('OFE_CATEGORIA', 0),
            'clicod' => $this->input('CLICOD', ''),
        ];
    }
}
