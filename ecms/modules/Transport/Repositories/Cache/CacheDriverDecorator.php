<?php

namespace Modules\Transport\Repositories\Cache;

use Modules\Transport\Repositories\DriverRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheDriverDecorator extends BaseCacheDecorator implements DriverRepository
{
    public function __construct(DriverRepository $driver)
    {
        parent::__construct();
        $this->entityName = 'transport.drivers';
        $this->repository = $driver;
    }
}
