<?php

namespace Modules\Maintenance\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterMaintenanceSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('maintenance::maintenances.title.maintenances'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('maintenance::events.title.events'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.maintenance.event.create');
                    $item->route('admin.maintenance.event.index');
                    $item->authorize(
                        $this->auth->hasAccess('maintenance.events.index')
                    );
                });
                $item->item(trans('maintenance::fueltanks.title.fueltanks'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.maintenance.fueltank.create');
                    $item->route('admin.maintenance.fueltank.index');
                    $item->authorize(
                        $this->auth->hasAccess('maintenance.fueltanks.index')
                    );
                });
                $item->item(trans('maintenance::tires.title.tires'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.maintenance.tire.create');
                    $item->route('admin.maintenance.tire.index');
                    $item->authorize(
                        $this->auth->hasAccess('maintenance.tires.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
