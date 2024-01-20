<?php

namespace Modules\Dynamicform\Repositories\Cache;

use Modules\Dynamicform\Repositories\FormResponseRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFormResponseDecorator extends BaseCacheDecorator implements FormResponseRepository
{
    public function __construct(FormResponseRepository $formresponse)
    {
        parent::__construct();
        $this->entityName = 'dynamicform.formresponses';
        $this->repository = $formresponse;
    }
}
