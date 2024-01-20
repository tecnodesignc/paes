<?php

namespace modules\Transport\Events\Handlers;

use Modules\Maintenance\Repositories\EventRepository;
use Modules\User\Permissions\PermissionManager;

class EventCreate
{
    /**
     * @var EventRepository
     */
    private EventRepository $event;


    public function __construct(EventRepository $event)
    {
        $this->event = $event;
    }


    public function handle($event)
    {
        $data = $event->getSubmissionData();
        $entity=$event->getEntity();
        if($data['alert']){
            $data_event=[
                'type'=>0,
                'description'=>'Renovar '.$entity->name,
                'alert'=>$entity->expiration_date,
                'alert_active'=>1,
                'status'=>1,
                'eventable_id'=>$entity->documentable_id,
                'eventable_type'=>$entity->documentable_type,
                'company_id' =>$entity->dcumentable->company_id
            ];
            $this->event->create($data_event);
        }

    }


}
