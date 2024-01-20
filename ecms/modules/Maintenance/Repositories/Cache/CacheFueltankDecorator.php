<?php

namespace Modules\Maintenance\Repositories\Cache;

use Modules\Maintenance\Repositories\FueltankRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFueltankDecorator extends BaseCacheDecorator implements FueltankRepository
{
    public function __construct(FueltankRepository $fueltank)
    {
        parent::__construct();
        $this->entityName = 'maintenance.fueltanks';
        $this->repository = $fueltank;
    }
}
