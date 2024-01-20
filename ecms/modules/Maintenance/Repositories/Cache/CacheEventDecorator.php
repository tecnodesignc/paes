<?php

namespace Modules\Maintenance\Repositories\Cache;

use Modules\Maintenance\Repositories\EventRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheEventDecorator extends BaseCacheDecorator implements EventRepository
{
    public function __construct(EventRepository $event)
    {
        parent::__construct();
        $this->entityName = 'maintenance.events';
        $this->repository = $event;
    }
}
