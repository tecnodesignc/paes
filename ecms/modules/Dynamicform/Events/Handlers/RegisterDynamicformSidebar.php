<?php

namespace Modules\Dynamicform\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterDynamicformSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('dynamicform::dynamicforms.title.dynamicforms'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('dynamicform::forms.title.forms'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.dynamicform.form.create');
                    $item->route('admin.dynamicform.form.index');
                    $item->authorize(
                        $this->auth->hasAccess('dynamicform.forms.index')
                    );
                });
                $item->item(trans('dynamicform::fields.title.fields'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.dynamicform.field.create');
                    $item->route('admin.dynamicform.field.index');
                    $item->authorize(
                        $this->auth->hasAccess('dynamicform.fields.index')
                    );
                });
                $item->item(trans('dynamicform::formresponses.title.formresponses'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.dynamicform.formresponse.create');
                    $item->route('admin.dynamicform.formresponse.index');
                    $item->authorize(
                        $this->auth->hasAccess('dynamicform.formresponses.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
