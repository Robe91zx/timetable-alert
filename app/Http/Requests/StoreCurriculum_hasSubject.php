<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCurriculum_hasSubject extends FormRequest
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
            'curriculum_id' => 'required',
            'subject_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'curriculum_id.required' => 'Debes Seleccionar un Curriculum',
            'subject_id.required' => 'Debes Seleccionar una Asignatura',
        ];
    }
}
