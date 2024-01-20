<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/devices'], function (Router $router) {

    $router->get('/', [
        'as' => 'apigpswox.devices.index',
        'uses' => 'DeviceController@index',
        'middleware' => 'auth'
    ]);

    $router->group(['prefix' =>'/{device}'], function (Router $router) {

        $router->get('/', [
            'as' => 'apigpswox.devices.show',
            'uses' => 'DeviceController@show',
            'middleware' => 'auth'
        ]);
        $router->group(['prefix' =>'/sensors'], function (Router $router) {

            $router->get('/', [
                'as' => 'apigpswox.sensor.index',
                'uses' => 'SensorController@index',
                'middleware' => 'auth'
            ]);
            $router->get('/{sensor}', [
                'as' => 'apigpswox.sensor.show',
                'uses' => 'SensorController@show',
                'middleware' => 'auth'
            ]);
        });

    });


});

$router->group(['prefix' =>'/reports'], function (Router $router) {

    $router->get('/', [
        'as' => 'apigpswox.report.index',
        'uses' => 'ReportController@index',
        'middleware' => 'auth'
    ]);
});


