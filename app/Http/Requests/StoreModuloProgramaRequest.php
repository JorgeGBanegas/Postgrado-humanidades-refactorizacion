<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuloProgramaRequest extends FormRequest
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
            'mod_program_nro' => 'required | numeric | min: 1',
            'mod_program_nom' => 'required | string',
            'docente' => 'required | numeric | exists: persona',
            'programa' => 'required | numeric | exists: programa'
        ];
    }
}
