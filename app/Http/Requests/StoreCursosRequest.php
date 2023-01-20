<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCursosRequest extends FormRequest
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
            'curs_nom' => 'required | string | unique:curso',
            'curs_fini' => 'required | date | after:today',
            'curs_precio' => 'required | numeric | min:0',
            'curs_modalidad'
            => [
                'required',
                Rule::in(["presencial", "semipresencial", "virtual"])
            ],
            'curs_duracion' => 'required | numeric | min:1'
        ];
    }

    public function messages()
    {
        return [
            'curs_fini.after' => 'La fecha no puede ser anterior a hoy'
        ];
    }
}
