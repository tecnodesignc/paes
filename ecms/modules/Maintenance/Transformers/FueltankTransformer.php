<?php

namespace Modules\Maintenance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class FueltankTransformer extends JsonResource
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
            'fuel_date' => $this->when($this->fuel_date, $this->fuel_date),
            'quantity' => $this->when($this->quantity, $this->quantity),
            'type' => $this->when($this->type, $this->type),
            'value' => $this->when($this->value, $this->value),
            'vehicle_id' => $this->when($this->vehicle_id, $this->vehicle_id),
            'company_id' => $this->when($this->company_id, $this->company_id),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'updated_at' => $this->when($this->updated_at, $this->updated_at),
        ];
        return $data;

    }
}
