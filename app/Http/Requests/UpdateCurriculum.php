<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCurriculum extends FormRequest
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
            'name' => ['required', Rule::unique('curriculums')->ignore($this->route()->curriculum->id)],
            'code' => ['required', Rule::unique('curriculums')->ignore($this->route()->curriculum->id)],
            'description' => 'required',
            'duration' => 'required',
            'carreer_vcode' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo Nombre es Obligatorio',
            'name.unique' => 'Este Nombre ya ha sido ingresado',
            'code.required' => 'El campo Codigo es Obligatorio',
            'code.unique' => 'Este Codigo ya ha sido ingresado',
            'description.required' => 'El campo Website es Obligatorio',
            'duration.required' => 'El campo duracion es Obligatorio',
    ];
    }
}
