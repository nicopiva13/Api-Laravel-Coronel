<?php

namespace App\Http\Requests\Oferta;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerCategoriaOfertaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'CAT' => 'required',
        ];
    }
}