<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
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
            'per_ci' => 'required| numeric |unique:persona| digits_between:7,15',
            'per_nom' => 'required',
            'per_appm' => 'required',
            'per_prof' => 'required',
            'per_telf' => 'required | numeric |  digits_between:7,15',
            'per_cel' => 'required | numeric |  digits_between:8,15',
            'per_email' => 'required|unique:persona|email:rfc,dns',
            'per_fnac' => 'required|date|before: 01/01/2005',
            'per_lnac' => 'required',
            'per_tipo' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'per_ci.required' => 'Por favor debe introducir el C.I.',
            'per_ci.unique' => 'El C.I. ya se encuentra registrado',
            'per_ci.numeric' => 'El C.I. Debe ser numerico',
            'per_ci.digits_between' => 'C.I. no valido numero muy corto',
            'per_nom.required' => 'Por favor debe introducir el nombre',
            'per_appm.required' => 'Por favor debe introducir el/los apellidos',
            'per_prof.required' => 'Por favor debe introducir la profesion',
            'per_telf.required' => 'Por favor debe introducir el telefono',
            'per_telf.numeric' => 'El telefono Debe ser numerico',
            'per_telf.digits_between' => 'Telefono no valido numero muy corto, minimo 7 digitos',
            'per_cel.required' => 'Por favor debe introducir el celular',
            'per_cel.numeric' => 'El celular Debe ser numerico',
            'per_cel.digits_between' => 'Celular no valido numero muy corto, minimo 8 digitos',
            'per_email.required' => 'Por favor debe introducir el email',
            'per_email.unique' => 'El email ya se encuentra registrado',
            'per_email.email' => 'El email no existe o no tiene un formato valido',
            'per_fnac.required' => 'Por favor debe introducir la fecha de nacimiento',
            'per_fnac.before' => 'Debe tener al menos 17 años',
            'per_lnac.required' => 'Por favor debe introducir el lugar de nacimiento',
            'per_tipo.required' => 'Por favor debe introducir el tipo de usuario',
            'per_tipo.numeric' => 'el id debe ser numerico',
        ];
    }
}
