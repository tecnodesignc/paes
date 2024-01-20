<?php

namespace Modules\Transport\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Sass\Transformers\CompanyTransformer;
use Modules\User\Transformers\UserProfileTransformer;

class DriverTransformer extends JsonResource
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
            'vehicle_id' => $this->when($this->vehicle_id, $this->id),
            'user_id' => $this->when($this->user_id, $this->user_id),
            'driver_license' => $this->when($this->driver_license, $this->driver_license),
            'phone' => $this->when($this->phone, $this->phone),
            'itineraries'=> RouteItineraryTransformer::collection($this->whenLoaded('itineraries')),
            'user'=> new UserProfileTransformer($this->user),
            'companies'=> CompanyTransformer::collection($this->whenLoaded('companies')),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'update_at' => $this->when($this->update_at, $this->update_at),
        ];

        return $data;

    }
}
