<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlanPagoRequest extends FormRequest
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
            'inscripcion_alumno' => 'required | numeric | exists:inscripcion_programa,inscrip_program_nro',
            'plan_pago_descrip' => 'sometimes|nullable|string',
            'pago_descuento' => 'required | numeric',
            'pago_total' => 'required | numeric',
            'tipo_pago' =>  'required | numeric | in:1,2'
        ];
    }

    public function messages()
    {
        return [];
    }
}
