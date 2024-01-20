<?php

namespace Modules\Dashboard\Repositories\Cache;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Dashboard\Repositories\WidgetRepository;

class CacheWidgetDecorator extends BaseCacheDecorator implements WidgetRepository
{
    public function __construct(WidgetRepository $widgets)
    {
        parent::__construct();
        $this->entityName = 'dashboard.widgets';
        $this->repository = $widgets;
    }

    /**
     * Find the saved state of widgets for the given user id
     * @param int $userId
     * @return Model|Collection|Builder|array|null
     */
    public function findForUser(int $userId): Model|Collection|Builder|array|null
    {
       $store=$this->cache;

        if (method_exists($this->cache->getStore(), 'tags')) {
            $store = $store->tags([$this->entityName, 'global']);
        }

        return $store->remember(
                "{$this->locale}.{$this->entityName}.findForUser.{$userId}",
                $this->cacheTime,
                function () use ($userId) {
                    return $this->repository->findForUser($userId);
                }
            );
    }

    /**
     * Update or create the given widgets for given user
     * @param array $widgets
     * @param int $userId
     * @return array|Builder|Collection|Model|null
     */
    public function updateOrCreateForUser(array $widgets, int $userId): Model|Collection|Builder|array|null
    {
        $store=$this->cache;

        if (method_exists($this->cache->getStore(), 'tags')) {
            $store = $store->tags([$this->entityName, 'global']);
        }

        return $store->remember(
                "{$this->locale}.{$this->entityName}.updateOrCreateForUser.{$userId}",
                $this->cacheTime,
                function () use ($widgets, $userId) {
                    return $this->repository->updateOrCreateForUser($widgets, $userId);
                }
            );
    }
}
