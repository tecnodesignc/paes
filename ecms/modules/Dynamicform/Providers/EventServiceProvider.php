<?php
namespace Modules\Dynamicform\Providers;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Dynamicform\Events\FormResponsesWasCreated;
use Modules\Dynamicform\Events\Handlers\SendNotification;

class EventServiceProvider extends ServiceProvider{

    protected $listen = [
        FormResponsesWasCreated::class => [
            SendNotification::class
        ]

    ];
}
