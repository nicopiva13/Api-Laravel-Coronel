<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerCondicionClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cli_codigo' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'cli_codigo.required' => 'El parámetro cli_codigo es obligatorio.',
        ];
    }
}
