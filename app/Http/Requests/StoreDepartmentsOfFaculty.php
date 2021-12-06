<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentsOfFaculty extends FormRequest
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
            'department_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'faculty_id.required' => 'Debes Seleccionar una Facultad',
            'department_id.required' => 'Debes Seleccionar un Departamento',
    ];
    }
}
