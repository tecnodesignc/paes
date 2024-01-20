<?php

namespace Modules\Transport\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterTransportSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('transport::transports.title.transports'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('transport.vehicles.index') || $this->auth->hasAccess('transport.drivers.index')
                );
                $item->item(trans('transport::vehicles.title.vehicles'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.transport.vehicles.create');
                    $item->route('admin.transport.vehicles.index');
                    $item->authorize(
                        $this->auth->hasAccess('transport.vehicles.index')
                    );
                });
                $item->item(trans('transport::drivers.title.drivers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.transport.driver.create');
                    $item->route('admin.transport.driver.index');
                    $item->authorize(
                        $this->auth->hasAccess('transport.drivers.index')
                    );
                });

// append

            });
        });

        return $menu;
    }
}
