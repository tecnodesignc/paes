<?php

namespace Modules\Notification\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;
use Illuminate\Support\Arr;

class NotificationTransformer extends Resource
{
    public function toArray($request): array
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'user_id' => $this->when($this->user_id, $this->user_id),
            'type'=> $this->when($this->type, $this->type),
            'message'=> $this->when($this->message, $this->message),
            'icon_class'=> $this->when($this->icon_class, $this->icon_class),
            'link'=> $this->when($this->link, $this->link),
            'is_read'=> $this->when($this->is_read, $this->is_read),
            'title'=> $this->when($this->title, $this->title),
            'user' => new UserProfileTransformer($this->whenLoaded('user')),
        ];

        return $data;

    }
}
