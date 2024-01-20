<?php

namespace Modules\Apigpswox\Services;


use Modules\User\Repositories\UserRepository;

class SensorService extends Connection
{


    public function __construct()
    {}

    public function getSensors($deviceId)
    {
        $this->params(['device_id'=>$deviceId]);

        $sensors = $this->get('/add_sensor_data');

        return $sensors;

    }

    public function getSensor($sensorId)
    {
        $this->params(['sensor_id'=>$sensorId]);

        $sensor = $this->get('/edit_sensor_data');

        return $sensor;

    }

    public function editSensor($sensorId,$data)
    {
        $this->params(['sensor_id'=>$sensorId]);

        $sensors = $this->post($data,'/edit_sensor');

        return $sensors;

    }

}
