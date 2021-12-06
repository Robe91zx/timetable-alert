<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarreersOfFaculty extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'faculty_id' => 'required',
            'carreer_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'faculty_id.required' => 'Debes Seleccionar una Facultad',
            'carreer_id.required' => 'Debes Seleccionar una Carrera',
    ];
    }
}
