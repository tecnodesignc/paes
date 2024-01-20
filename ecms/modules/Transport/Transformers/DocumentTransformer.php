<?php

namespace Modules\Transport\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class DocumentTransformer extends JsonResource
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
            'vehicle_id' => $this->when($this->vehicle_id, $this->vehicle_id),
            'name' =>  $this->when($this->name, $this->name),
            'extension' => $this->when($this->extension, $this->extension),
            'route' => $this->when($this->route, $this->route),
            'expiration_date'=> $this->when($this->expiration_date, $this->expiration_date),
            'amount'=> $this->when($this->amount, $this->amount),
            'alert'=> [
                'value'=>boolval($this->alert),
                'class_alert'=>$this->present()->classAlert,
                'status_alert'=>$this->present()->statusAlert,
            ],
            'created_at' => $this->when($this->created_at, $this->created_at),
            'updated_at' => $this->when($this->updated_at, $this->updated_at),
        ];

        return $data;

    }
}
