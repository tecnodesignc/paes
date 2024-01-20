<?php

namespace Modules\Menu\Repositories\Cache;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Menu\Repositories\MenuItemRepository;

class CacheMenuItemDecorator extends BaseCacheDecorator implements MenuItemRepository
{

    public function __construct(MenuItemRepository $menuItem)
    {
        parent::__construct();
        $this->entityName = 'menusItems';
        $this->repository = $menuItem;
    }

    /**
     * Get online root elements
     *
     * @param int $menuId
     * @return Collection
     */
    public function rootsForMenu(int $menuId): Collection
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->rootsForMenu($menuId);
        });
    }

    /**
     * Get the menu items ready for routes
     * @return mixed
     */
    public function getForRoutes():mixed
    {
        return $this->remember(function () {
            return $this->repository->getForRoutes();
        });
    }

    /**
     * Get the root menu item for the given menu id
     * @param int $menuId
     * @return array|Builder|Collection|Model|null
     */
    public function getRootForMenu(int $menuId):array|Builder|Collection|Model|null
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->getRootForMenu($menuId);
        });
    }

    /**
     * Return a complete tree for the given menu id
     *
     * @param int $menuId
     * @return object
     */
    public function getTreeForMenu(int $menuId): object
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->getTreeForMenu($menuId);
        });
    }

    /**
     * Get all root elements
     *
     * @param int $menuId
     * @return Collection
     */
    public function allRootsForMenu(int $menuId): Collection
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->allRootsForMenu($menuId);
        });
    }

    /**
     * @param string $uri
     * @param string $locale
     * @return array|Builder|Collection|Model|null
     */
    public function findByUriInLanguage(string $uri, string $locale): array|Builder|Collection|Model|null
    {
        return $this->remember(function () use ($uri, $locale) {
            return $this->repository->findByUriInLanguage($uri, $locale);
        });
    }
}
