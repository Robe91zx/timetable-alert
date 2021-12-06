<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCollege extends FormRequest
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
            'code' => ['required',Rule::unique('colleges')->ignore($this->route()->college->id)],
            'name' => ['required',Rule::unique('colleges')->ignore($this->route()->college->id)],
            'website' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'El campo Codigo es Obligatorio',
            'code.unique' => 'Este Codigo ya ha sido ingresado',
            'name.required' => 'El campo Nombre es Obligatorio',
            'name.unique' => 'Este Nombre ya ha sido ingresado',
            'website.required' => 'El campo Website es Obligatorio',
            'email.email' => 'Ingresa un email valido Ejemplo:email@uta.cl',
            'email.required' => 'El campo email es Obligatorio',
            'phone.required' => 'El campo telefono es Obligatorio',
    ];
    }
}
