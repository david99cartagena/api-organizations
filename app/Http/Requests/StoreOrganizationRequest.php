<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Puedes agregar lógica de permisos aquí si quieres
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:organizations,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la organización es obligatorio',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'name.unique' => 'Ya existe una organización con ese nombre',
        ];
    }
}
