<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificadoProgramaRequest extends FormRequest
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
            'cert_program_descrip' => 'required',
            'cert_program_fecha' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'cert_program_descrip.required' => 'Necesita escribir una descripcion',
            'cert_program_fecha.required' => 'La fecha es obligatoria'
        ];
    }
}
