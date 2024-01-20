<?php

namespace Modules\Dynamicform\Repositories\Cache;

use Modules\Dynamicform\Repositories\FormRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFormDecorator extends BaseCacheDecorator implements FormRepository
{
    public function __construct(FormRepository $form)
    {
        parent::__construct();
        $this->entityName = 'dynamicform.forms';
        $this->repository = $form;
    }
}
