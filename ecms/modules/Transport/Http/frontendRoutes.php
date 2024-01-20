<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/transport'], function (Router $router) {

    $router->group(['prefix' => '/vehicles'], function (Router $router) {

        $router->bind('vehicles', function ($id) {
            return app('Modules\Transport\Repositories\VehiclesRepository')->find($id);
        });

        $router->get('/', [
            'as' => 'transport.vehicles.index',
            'uses' => 'VehiclesController@index',
            'middleware' => 'can:transport.vehicles.index'
        ]);
        $router->get('/create', [
            'as' => 'transport.vehicles.create',
            'uses' => 'VehiclesController@create',
            'middleware' => 'can:transport.vehicles.create'
        ]);
        $router->post('/', [
            'as' => 'transport.vehicles.store',
            'uses' => 'VehiclesController@store',
            'middleware' => 'can:transport.vehicles.create'
        ]);
        $router->get('/{vehicles}/edit', [
            'as' => 'transport.vehicles.edit',
            'uses' => 'VehiclesController@edit',
            'middleware' => 'can:transport.vehicles.edit'
        ]);
        $router->put('/{vehicles}', [
            'as' => 'transport.vehicles.update',
            'uses' => 'VehiclesController@update',
            'middleware' => 'can:transport.vehicles.edit'
        ]);
        $router->delete('/{vehicles}', [
            'as' => 'transport.vehicles.destroy',
            'uses' => 'VehiclesController@destroy',
            'middleware' => 'can:transport.vehicles.destroy'
        ]);

    });

    $router->group(['prefix' => '/drivers'], function (Router $router) {

        $router->bind('driver', function ($id) {
            return app('Modules\Transport\Repositories\DriverRepository')->find($id);
        });

        $router->get('/', [
            'as' => 'transport.driver.index',
            'uses' => 'DriverController@index',
            'middleware' => 'can:transport.drivers.index'
        ]);
        $router->get('/create', [
            'as' => 'transport.driver.create',
            'uses' => 'DriverController@create',
            'middleware' => 'can:transport.drivers.create'
        ]);
        $router->post('/', [
            'as' => 'transport.driver.store',
            'uses' => 'DriverController@store',
            'middleware' => 'can:transport.drivers.create'
        ]);
        $router->get('/{driver}/edit', [
            'as' => 'transport.driver.edit',
            'uses' => 'DriverController@edit',
            'middleware' => 'can:transport.drivers.edit'
        ]);
        $router->put('/{driver}', [
            'as' => 'transport.driver.update',
            'uses' => 'DriverController@update',
            'middleware' => 'can:transport.drivers.edit'
        ]);
        $router->delete('/{driver}', [
            'as' => 'transport.driver.destroy',
            'uses' => 'DriverController@destroy',
            'middleware' => 'can:transport.drivers.destroy'
        ]);
        $router->get('/import', [
            'as' => 'transport.driver.import-view',
            'uses' => 'DriverController@importView',
            'middleware' => 'can:transport.passengers.create'
        ]);
        $router->post('/import', [
            'as' => 'transport.driver.import',
            'uses' => 'DriverController@import',
            'middleware' => 'can:transport.passengers.create'
        ]);
    });

// append


});
