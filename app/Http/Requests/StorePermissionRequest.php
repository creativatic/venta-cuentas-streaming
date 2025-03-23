<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
         return [
             'title' => 'required|string|max:255|unique:permissions',
         ];
        //return [
        //    'title' => [
        //        'required',
        //        'string',
        //        'max:255',
        //        'unique:permissions,title',
        //        'regex:/^[a-z][a-z0-9\s-_]*$/', // Comienza con minúscula, permite alfanumérico, espacios, guiones y guiones bajos
        //    ],
        //];        
    }

    public function messages()
    {
        return [
            'title.required' => 'El título del permiso es obligatorio',
            'title.unique' => 'Este título de permiso ya está en uso',
            'title.regex' => 'El formato del permiso debe comenzar con minúscula y solo puede contener letras, números, espacios, guiones y guiones bajos',
        ];
    }

}