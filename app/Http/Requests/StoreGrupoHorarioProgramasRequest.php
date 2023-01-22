<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGrupoHorarioProgramasRequest extends FormRequest
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
            'grup_program_cod' => 'required | string',
            'grup_program_vers' => 'required | string',
            'grup_program_edic' => 'required | string',
            'grup_program_fini' => 'required | date ',

            'horarios.*.dia' =>  ['required', Rule::in(["lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo"])],
            'horarios.*.hini' => ['required', 'date_format:HH:mm'],
            'horarios.*.hfin' => ['required', 'date_format:HH:mm', 'after:horarios.*.hini'],
        ];
    }
}
