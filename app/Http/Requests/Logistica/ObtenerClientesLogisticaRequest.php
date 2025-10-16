<?php

namespace App\Http\Requests\Clientes;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerClientesLogisticaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'P' => 'nullable|string|max:50',
        ];
    }
}