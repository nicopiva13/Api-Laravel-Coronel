<?php

namespace App\Http\Requests\Oferta;

use Illuminate\Foundation\Http\FormRequest;

class ArticuloEnOfertaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cli_categoria' => 'required',
            'codtex' => 'required',
        ];
    }
}