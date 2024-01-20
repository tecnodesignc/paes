<?php

namespace Modules\Sass\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class CompanyTransformer extends JsonResource
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
            'name'=> $this->when($this->name, $this->name),
            'logo'=>$this->present()->gravatar(),
            'settings'=>[]
        ];

        if ($this->setting){
            foreach ($this->setting->value as $i => $item){
                $data['settings'][$i]=$item;
            }
        }

        return $data;

    }
}
