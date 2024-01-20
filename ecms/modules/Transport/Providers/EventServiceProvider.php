<?php

namespace Modules\Transport\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use modules\Transport\Events\DocumentWasCreated;
use Modules\Transport\Events\DriverIsCreating;
use Modules\Transport\Events\DriverIsUpdating;
use modules\Transport\Events\Handlers\EventCreate;
use Modules\Transport\Events\Handlers\UpdateTicketPassenger;
use Modules\Transport\Events\Handlers\UserCreated;
use Modules\Transport\Events\Handlers\UserUpdated;
use Modules\Transport\Events\ItinerariesWasCreated;
use Modules\Transport\Events\PassengerIsCreating;
use Modules\Transport\Events\PassengerIsUpdating;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DriverIsCreating::class=>[
            UserCreated::class
        ],
        DriverIsUpdating::class=>[
            UserUpdated::class
        ],
        DocumentWasCreated::class=>[
            EventCreate::class
        ]

    ];

}
