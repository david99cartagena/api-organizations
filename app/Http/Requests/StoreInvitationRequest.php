<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Puedes agregar lógica de permisos aquí si quieres
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'role' => 'required|in:manager,member'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ser un correo válido',
            'role.required' => 'El rol es obligatorio',
            'role.in' => 'El rol debe ser manager o member',
        ];
    }
}
