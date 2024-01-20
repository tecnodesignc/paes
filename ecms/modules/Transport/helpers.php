<?php

use Carbon\Carbon as Carbon;

if (function_exists('driverCount') === false) {
    function driverCount($options = array()): int
    {
        $driver= app('Modules\Transport\Repositories\DriverRepository');
        $parameters=json_decode(json_encode(['filter'=>$options,'include'=>[],'take'=>null]));
        $drivers = $driver->getItemsBy($parameters);

        return $drivers->count()??0;
    }
}

