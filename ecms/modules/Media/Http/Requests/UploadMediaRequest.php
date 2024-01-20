<?php

namespace Modules\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Media\Validators\MaxFolderSizeRule;

class UploadMediaRequest extends FormRequest
{
    public function rules(): array
    {
        $extensions = 'mimes:' . str_replace('.', '', config('encore.media.config.allowed-types'));
        $maxFileSize = $this->getMaxFileSizeInKilobytes();

        return [
            'file' => [
                'required',
                new MaxFolderSizeRule(),
                $extensions,
                "max:$maxFileSize",
            ],
        ];
    }

    public function messages(): array
    {
        $size = $this->getMaxFileSize();

        return [
            'file.max' => trans('media::media.file too large', ['size' => $size]),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    private function getMaxFileSizeInKilobytes(): float|int
    {
        return $this->getMaxFileSize() * 1000;
    }

    private function getMaxFileSize()
    {
        return config('encore.media.config.max-file-size');
    }
}
