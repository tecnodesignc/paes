<?php

namespace Modules\Transport\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateDriverRequest extends BaseFormRequest
{
    public function rules()
    {
       $user_id=$this->user->id??$this->user['id'];
        return [
            'email' => "required|email|unique:users,email,{$user_id}",
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'confirmed',
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
