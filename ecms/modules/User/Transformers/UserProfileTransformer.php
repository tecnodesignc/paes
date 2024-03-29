<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->when($this->present()->fullname, $this->present()->fullname),
            'email' => $this->email,
            'is_activated' => $this->isActivated(),
            'api_key'=>$this->getFirstApiKey(),
            'main_image' => $this->present()->gravatar(),
            'created_at' => $this->created_at,
        ];
    }
}
