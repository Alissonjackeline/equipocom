<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user'); // Asumiendo que la ruta es user/{user}

        return [
            'document' => [
                'required',
                'string',
                'size:8',
                'regex:/^[0-9]+$/',
                Rule::unique('users', 'Document')->ignore($userId, 'idUser')
            ],
            'name' => 'required|string|max:70',
            'phone' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users', 'Email')->ignore($userId, 'idUser')
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'document.required' => 'El DNI es obligatorio.',
            'document.size' => 'El DNI debe tener 8 dígitos.',
            'document.regex' => 'El DNI solo debe contener números.',
            'document.unique' => 'Este DNI ya está registrado.',
            'name.required' => 'Los nombres completos son obligatorios.',
            'name.max' => 'Los nombres no pueden exceder los 70 caracteres.',
            'phone.required' => 'El teléfono es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'document' => 'DNI',
            'name' => 'nombres completos',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
        ];
    }
}