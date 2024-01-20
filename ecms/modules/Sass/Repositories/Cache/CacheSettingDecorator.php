<?php

namespace Modules\Sass\Repositories\Cache;

use Modules\Sass\Repositories\SettingRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSettingDecorator extends BaseCacheDecorator implements SettingRepository
{
    public function __construct(SettingRepository $setting)
    {
        parent::__construct();
        $this->entityName = 'sass.settings';
        $this->repository = $setting;
    }
}
