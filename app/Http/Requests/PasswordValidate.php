<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordValidate extends FormRequest
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
    public function messages()
    {
        return [
            'passwordold.required'  => 'Введите пароль',
            'passwordold.min:6'  => 'Пароль должен быть не меньше 6 символов',
            'password.required'  => 'Введите пароль',
            'password.min:6'  => 'Пароль должен быть не меньше 6 символов',
            'password_confirmation.required' =>'Введите пароль',
            'password_confirmation.min:6' => 'Пароль должен быть не меньше 6 символов',
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
            'passwordold' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ];
    }
}
