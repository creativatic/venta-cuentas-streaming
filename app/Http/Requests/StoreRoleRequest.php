<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // O usa Gate::allows('manage roles')
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'unique:roles,title'
            ],
            'permissions.*' => [
                'integer',
                'exists:permissions,id',
            ],
            'permissions' => [
                'array',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'El título del rol es obligatorio',
            'title.unique' => 'Este título de rol ya está en uso',
            'permissions.*.exists' => 'Uno de los permisos seleccionados no existe',
        ];
    }
}