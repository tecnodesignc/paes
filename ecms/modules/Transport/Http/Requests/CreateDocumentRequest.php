<?php

namespace Modules\Transport\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateDocumentRequest extends BaseFormRequest
{
    public function rules()
    {
        return ['file'=>'required'];
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
