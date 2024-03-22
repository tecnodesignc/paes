<?php

namespace Modules\Dynamicform\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Sass\Transformers\CompanyTransformer;

class FormTransformer extends JsonResource
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
            'caption'=> $this->when($this->caption, $this->caption),
            'icon'=> $this->when($this->icon, $this->icon),
            'color'=> $this->when($this->color, $this->color),
            'active'=>boolval($this->active),
            'companies'=> CompanyTransformer::collection($this->whenLoaded('companies')),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'update_at' => $this->when($this->created_at, $this->created_at),
            'company_create' => $this->when($this->company_create, $this->company_create),
        ];

        return $data;

    }
}
