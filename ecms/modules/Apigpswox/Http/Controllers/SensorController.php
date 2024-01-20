<?php

namespace Modules\Apigpswox\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Apigpswox\Services\DeviceService;
use Modules\Apigpswox\Services\SensorService;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Entities\Page;

class SensorController extends BasePublicController
{
    /**
     * @var SensorService
     */
    private SensorService  $sensor;
    /**
     * @var Application
     */
    private Application $app;

    private DeviceService $device;


    public function __construct(Application $app, SensorService $sensor, DeviceService $device)
    {
        parent::__construct();

        $this->app = $app;
        $this->sensor = $sensor;
        $this->device=$device;
    }


    /**
     * @return View
     */
    public function index($device_id, Request $request): View
    {
      $params=$request->all();

        $sensors= $this->device->getDevice($device_id,$params)->sensors;
        dd($sensors);

        return view('apigpswox::frontend.sensor.index', compact('sensors'));
    }

    /**
     * @param $device_id
     * @param $sensor_id
     * @return View
     */
    public function show($device_id,$sensor_id): View
    {
        $sensor= $this->sensor->getSensor($sensor_id);
        dd($sensor);
        return view('apigpswox::frontend.sensor.show', compact('sensor'));
    }


}
