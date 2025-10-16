<?php

namespace App\Http\Requests\Transporte;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerTransporteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'C' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'C.required' => 'El campo C es obligatorio.',
        ];
    }
}
