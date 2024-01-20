<?php

namespace Modules\Apigpswox\Services;


use http\Params;
use Modules\User\Repositories\UserRepository;

class DeviceService extends Connection
{

    /**
     * @var UserRepository
     */
    private UserRepository $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function GetDevices()
    {
        $this->params();
        $device = $this->get('/get_devices');

        return $device;

    }

    public function GetDevice($device_id, $params)
    {

        $this->params(array_merge(['device_id'=>$device_id],$params));
        return $this->get('/edit_device_data');

    }

}
