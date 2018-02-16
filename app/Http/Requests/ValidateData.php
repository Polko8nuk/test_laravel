<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateData extends FormRequest
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

    public function messages()
    {
        return [
            'name.required' => 'Введите имя' ,
            'login.required' => 'Введите логин',
            'email.required'  => 'Введите email',
            'email.email'  => 'Введите email в формате @',
            'password1.required'  => 'Введите пароль',
            'password1.min:6'  => 'Пароль должен быть не меньше 6 символов',
        ];
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
            'login' => 'required',
            'email' => 'required',
            'password1' => 'required|min:6',
        ];
    }



}
