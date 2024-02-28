<?php

namespace Modules\Transport\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateDriverRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => "required|email",
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
