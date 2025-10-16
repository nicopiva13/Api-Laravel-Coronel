<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerClientesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'C' => 'nullable',
            'D' => 'nullable',
        ];
    }

    public function obtenerCUIT(): string
    {
        return $this->query('C', '');
    }

    public function obtenerDNI(): string
    {
        return $this->query('D', '');
    }
}