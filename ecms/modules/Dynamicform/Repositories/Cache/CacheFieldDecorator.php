<?php

namespace Modules\Dynamicform\Repositories\Cache;

use Modules\Dynamicform\Repositories\FieldRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFieldDecorator extends BaseCacheDecorator implements FieldRepository
{
    public function __construct(FieldRepository $field)
    {
        parent::__construct();
        $this->entityName = 'dynamicform.fields';
        $this->repository = $field;
    }
}
