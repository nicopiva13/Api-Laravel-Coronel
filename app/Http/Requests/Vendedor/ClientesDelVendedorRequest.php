<?php

namespace App\Http\Requests\Vendedor;

use Illuminate\Foundation\Http\FormRequest;

class ClientesDelVendedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cli_vendedor' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'cli_vendedor.required' => 'El código del vendedor es obligatorio.',
        ];
    }
}
