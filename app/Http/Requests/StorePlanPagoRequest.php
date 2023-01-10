<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'plan_pago_pagtot' => 'required | numeric | min:0 '
        ];
    }

    public function messages()
    {
        return [
            'plan_pago_pagtot.required' => 'El monto a pagar es obligatorio',
            'plan_pago_pagtot.numeric' => 'El monto debe ser numerico y positivo',
        ];
    }
}
