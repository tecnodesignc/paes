<?php

namespace Modules\Transport\Repositories\Cache;

use Modules\Transport\Repositories\VehiclesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheVehiclesDecorator extends BaseCacheDecorator implements VehiclesRepository
{
    public function __construct(VehiclesRepository $vehicles)
    {
        parent::__construct();
        $this->entityName = 'transport.vehicles';
        $this->repository = $vehicles;
    }
}
