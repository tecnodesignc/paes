<?php

namespace Modules\Media\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterMediaSidebar extends AbstractAdminSidebar
{
    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu): Menu
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('media::media.title.media'), function (Item $item) {
                $item->weight(20);
                $item->icon('fa fa-camera');
                $item->route('admin.media.media.index');
                $item->authorize(
                    $this->auth->hasAccess('media.medias.index')
                );
            });
        });

        return $menu;
    }
}
