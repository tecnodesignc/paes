<?php

namespace Modules\Notification\Events\Handlers;

use Maatwebsite\Sidebar\Menu;
use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterNotificationSidebar extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items
     *
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu): Menu
    {
        return $menu;
    }
}
