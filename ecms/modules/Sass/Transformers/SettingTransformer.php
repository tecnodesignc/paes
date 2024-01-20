<?php

namespace Modules\Sass\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class SettingTransformer extends JsonResource
{

    /**
    * Transform the resource into an array.
    *
    * @param Request  $request
    * @return array
    */

    public function toArray($request): array
    {

        $data = [
            'id' => $this->when($this->id, $this->id),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'update_at' => $this->when($this->created_at, $this->created_at),
        ];

        return $data;

    }
}
