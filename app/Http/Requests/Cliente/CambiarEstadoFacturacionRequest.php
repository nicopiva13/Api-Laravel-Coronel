<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class CambiarEstadoFacturacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cli_FERecibeMail' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'cli_FERecibeMail.required' => 'El campo cli_FERecibeMail es obligatorio.',
            'cli_FERecibeMail.boolean'  => 'El campo cli_FERecibeMail debe ser booleano.',
        ];
    }
}