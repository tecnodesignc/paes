<?php

namespace Modules\Apigpswox\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateTokenRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
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
