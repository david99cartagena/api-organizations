<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcceptInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Solo se valida si el usuario no existe
        return [
            'name' => 'required_if:user_missing,true|string|max:255',
            'password' => 'required_if:user_missing,true|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required_if' => 'El nombre es obligatorio para crear el usuario',
            'password.required_if' => 'La contraseña es obligatoria para crear el usuario',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ];
    }
}
