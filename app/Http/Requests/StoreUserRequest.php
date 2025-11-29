<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
        return [
            'Document' => [
                'required',
                'string',
                'size:8',
                'regex:/^[0-9]+$/',
                Rule::unique('users', 'Document')
            ],
            'Name' => 'required|string|max:70',
            'Phone' => 'required|string|max:20',
            'Email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users', 'Email')
            ],
            'Password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name'
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
            'Document.required' => 'El DNI es obligatorio.',
            'Document.size' => 'El DNI debe tener 8 dígitos.',
            'Document.regex' => 'El DNI solo debe contener números.',
            'Document.unique' => 'Este DNI ya está registrado.',
            'Name.required' => 'Los nombres completos son obligatorios.',
            'Name.max' => 'Los nombres no pueden exceder los 70 caracteres.',
            'Phone.required' => 'El teléfono es obligatorio.',
            'Email.required' => 'El correo electrónico es obligatorio.',
            'Email.email' => 'El formato del correo electrónico no es válido.',
            'Email.unique' => 'Este correo electrónico ya está registrado.',
            'Password.required' => 'La contraseña es obligatoria.',
            'Password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'Password.confirmed' => 'Las contraseñas no coinciden.',
            'role.required' => 'El rol es obligatorio.',
            'role.exists' => 'El rol seleccionado no es válido.',
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
            'Document' => 'DNI',
            'Name' => 'nombres completos',
            'Phone' => 'teléfono',
            'Email' => 'correo electrónico',
            'Password' => 'contraseña',
            'role' => 'rol',
        ];
    }
}