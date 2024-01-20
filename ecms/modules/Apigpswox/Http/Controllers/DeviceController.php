<?php

namespace Modules\Apigpswox\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\View;
use Modules\Apigpswox\Services\DeviceService;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Entities\Page;

class DeviceController extends BasePublicController
{
    /**
     * @var DeviceService
     */
    private DeviceService  $device;
    /**
     * @var Application
     */
    private Application $app;


    public function __construct(Application $app, DeviceService $device)
    {
        parent::__construct();

        $this->app = $app;
        $this->device = $device;
    }


    /**
     * @return View
     */
    public function index(): View
    {

        $devices= $this->device->getDevices()[0]->items;

        return view('apigpswox::frontend.device.index', compact('devices'));
    }

    /**
     * @param $device_id
     * @return View
     */
    public function show($device_id): View
    {
        $device= $this->device->getDevice($device_id);

        return view('apigpswox::frontend.device.show', compact('device'));
    }


}
