<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubject extends FormRequest
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
            'vcode' => 'required|unique:subjects',
            'code' => 'required|unique:subjects',
            'name' => 'required',
            'semester' => 'required',
            'hours' => 'required',
            'faculty_vcode' => 'required',
            'state' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'El campo Codigo es Obligatorio',
            'code.unique' => 'Este Codigo ya ha sido ingresado',
            'name.required' => 'El campo Nombre es Obligatorio',
            'semester.required' => 'El campo Semestre es Obligatorio',
            'hours.required' => 'El campo horas es Obligatorio',
            'faculty_vcode.required' => 'Debes asignar la asignatura a una facultad',
            'state.required' => 'Debes asignar un estado para la asignatura',
    ];
    }
}
