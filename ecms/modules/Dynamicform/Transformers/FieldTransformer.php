<?php

namespace Modules\Dynamicform\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class FieldTransformer extends JsonResource
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
            'label' => $this->when($this->label, $this->label),
            'name' => $this->when($this->name, $this->name),
            'type' => $this->when($this->type, $this->type),
            'required' => boolval($this->required),
            'order' => $this->when($this->order, $this->order),
            'selectable' => $this->when($this->selectable, $this->selectable),
            'form_id' => $this->when($this->form_id, $this->form_id),
            'company_id' => $this->when($this->company_id, $this->company_id),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'update_at' => $this->when($this->created_at, $this->created_at),
        ];

        return $data;

    }
}
