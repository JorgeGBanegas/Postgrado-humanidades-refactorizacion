<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDescuentosRequest extends FormRequest
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
            'desc_motivo' => 'required | string',
            'desc_descrip' => 'sometimes|nullable|string',
            'desc_porce' => 'required|numeric|between:0,100',
            'program_id' => 'required|exists:programa,program_id',
        ];
    }
}
