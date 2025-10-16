<?php

namespace App\Http\Requests\Oferta;

use Illuminate\Foundation\Http\FormRequest;

class VerificarOfertaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cli_categoria' => 'required',
            'ofe_codtex' => 'required',
            'ofe_codnum' => 'required',
        ];
    }
}