<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCurriculum extends FormRequest
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
            'name' => 'required',
            'code' => 'required|unique:curriculums',
            'description' => 'required',
            'duration' => 'required',
            'carreer_vcode' => 'required',
            'state' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo Nombre es Obligatorio',
            'code.required' => 'El campo Codigo es Obligatorio',
            'code.unique' => 'Este Codigo ya ha sido ingresado',
            'description.required' => 'Debes agregar una descripcion',
            'duration.required' => 'El campo duracion es Obligatorio',
            'carreer_vcode.required' => 'Debes asignar la malla a una carrera',
            'state' => 'Debes determinar el estado de la malla'
        ];
    }
}
