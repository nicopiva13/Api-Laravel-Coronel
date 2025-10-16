<?php

namespace App\Http\Requests\Marcas;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerMarcasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'T'   => 'nullable',
            'R'   => 'nullable',
            'L'   => 'nullable',
            'F'   => 'nullable',
            'ORD' => 'nullable',
        ];
    }
}
