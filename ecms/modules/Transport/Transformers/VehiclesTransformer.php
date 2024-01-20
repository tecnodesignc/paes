<?php

namespace Modules\Transport\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Sass\Transformers\CompanyTransformer;

class VehiclesTransformer extends JsonResource
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
            'brand' => $this->when($this->brand, $this->brand),
            'plate' => $this->when($this->plate, $this->plate),
            'model' => $this->when($this->model, $this->model),
            'class' => $this->when($this->class, $this->class),
            'capacity' => $this->when($this->capacity, $this->capacity),
            'documents'=> DocumentTransformer::collection($this->whenLoaded('documents')),
            'driver'=> new DriverTransformer($this->whenLoaded('driver')),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'company'=> new CompanyTransformer($this->whenLoaded('company')),
        ];
        return $data;

    }
}
