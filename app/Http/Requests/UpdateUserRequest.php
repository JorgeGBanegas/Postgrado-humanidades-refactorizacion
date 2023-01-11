<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required | string | max:255',
            'last_name' => 'required | string | max:255',
            'password' => 'required | string | min:8 |confirmed',
            'type' => 'required | string | max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required ' => 'El nombre es obligatorio',
            'name.string ' => 'El nombre solo debe contener letras',
            'last_name.required' => 'El apellido es obligatorio',
            'last_name.string' => 'El apellido solo debe contener letras',
            'password.required' => 'La contraseña es obligatoria',
            'password.string' => 'La contraseña es obligatoria',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'type.required' => 'El tipo de usuario es obligatorio',
        ];
    }
}
