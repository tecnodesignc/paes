<?php

namespace Modules\Dynamicform\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Sass\Transformers\CompanyTransformer;
use Modules\User\Transformers\UserTransformer;

class FormResponseTransformer extends JsonResource
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
            'form_id'=>$this->when($this->form_id,$this->form_id),
            'form'=> new FormTransformer($this->whenLoaded('form')),
            'user_id'=>$this->when($this->user_id,$this->user_id),
            'user'=> new UserTransformer($this->whenLoaded('user')),
            'company_id'=>$this->when($this->form_id,$this->form_id),
            'company'=> new CompanyTransformer($this->whenLoaded('company')),
            'info'=>$this->when($this->data,$this->data->info),
            'answers'=>$this->when($this->data,$this->data->answers),
            'negative_num'=>$this->present()->negative_num(),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'update_at' => $this->when($this->created_at, $this->created_at),
        ];

        return $data;

    }
}
