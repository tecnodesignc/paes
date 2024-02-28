<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        $user = $this->route()->parameter('users');
        return [
           'email' => "required|email|unique:users,email,{$user}",
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'confirmed',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }
}
