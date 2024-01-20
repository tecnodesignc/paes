<?php

namespace Modules\Maintenance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Sass\Transformers\CompanyTransformer;
use Modules\Transport\Transformers\VehiclesTransformer;

class EventTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */

    public function toArray($request): array
    {

        $data = [
            'id' => $this->when($this->id, $this->id),
            'type' => intval($this->type),
            'type_name'=>$this->present()->type,
            'type_class'=>$this->present()->type_class,
            'description' => $this->when($this->description, $this->description),
            'alert' => $this->alert??null,
            'alert_active' => $this->when($this->alert_active, $this->alert_active),
            'limit' => $this->limit??null,
            'status' => intval($this->status),
            'status_name'=>$this->present()->status,
            'status_class'=>$this->present()->status_class,
            'eventable_id' => $this->when($this->eventable_id, $this->eventable_id),
            'eventable_type' => $this->when($this->eventable_type, $this->eventable_type),
            'company_id' => $this->when($this->company_id, $this->company_id),
            'company'=> new CompanyTransformer($this->whenLoaded('company')),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'update_at' => $this->when($this->created_at, $this->created_at),
        ];
       switch ($this->eventable_type){
           case 'Modules\Transport\Entities\Vehicles':
               $data['vehicle']=new VehiclesTransformer($this->eventable);
               break;
           default:


       }

        return $data;

    }
}
