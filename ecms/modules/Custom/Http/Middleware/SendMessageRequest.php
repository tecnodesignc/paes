<?php

namespace Modules\Custom\Http\Middleware;

use Modules\Core\Internationalisation\BaseFormRequest;

class SendMessageRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'phone'=>'required|max:13',
            'message'=>'required|max:160'
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
