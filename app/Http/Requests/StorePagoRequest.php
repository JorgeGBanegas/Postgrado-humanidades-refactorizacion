<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoRequest extends FormRequest
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
            'pago_concepto' => 'required',
            'pago_fecha_cobro' => 'required | date | after: today',
            'pago_monto' => 'required | numeric | min:0'
        ];
    }

    public function messages()
    {
        return [
            'pago_concepto.required' => 'Necesita escribir el concepto del pago',
            'pago_fecha_cobro.required' => 'La fecha de cobro es obligatoria',
            'pago_fecha_cobro.after' => 'La fecha debe ser despues de la actual',
            'pago_monto.required' => 'El monto es obligatorio',
            'pago_monto.numeric' => 'El monto debe ser numerico y positivo',

        ];
    }
}
