<?php

namespace Modules\Menu\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Menu\Repositories\MenuRepository;

class CacheMenuDecorator extends BaseCacheDecorator implements MenuRepository
{

    public function __construct(MenuRepository $menu)
    {
        parent::__construct();
        $this->entityName = 'menus';
        $this->repository = $menu;
    }

    /**
     * Get all online menus
     * @return object
     */
    public function allOnline(): object
    {
        return $this->remember(function () {
            return $this->repository->allOnline();
        });
    }
}
