<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        //return [
        //    'title' => 'required|string|max:255|unique:permissions,title,' . $this->permission->id,
        //];

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($this->permission),
            ],
            'roles.*' => 'exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El título del permiso es obligatorio.',
            'title.string' => 'El título debe ser un texto.',
            'title.max' => 'El título no debe exceder los 255 caracteres.',
            'title.unique' => 'Este título de permiso ya está en uso.',
            'roles.*.exists' => 'Uno de los roles seleccionados no existe.',
        ];
    }

}