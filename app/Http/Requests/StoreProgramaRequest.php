<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProgramaRequest extends FormRequest
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
            'program_nom'  => 'required | string |unique:programa',
            'program_precio'  => 'required | numeric | min:0',
            'program_tipo' => [
                'required',
                Rule::in(["diplomado", "maestria", "especialidad", "doctorado"])
            ],
            'program_modalidad' => [
                'required',
                Rule::in(["presencial", "semipresencial", "virtual"])
            ],
            'program_carrera' => [
                'required',
                Rule::exists('carrera', 'carr_id'),
            ],
        ];
    }
}
