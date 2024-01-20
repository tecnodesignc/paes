<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/transport'], function (Router $router) {
$router->group(['prefix' =>'/vehicles'], function (Router $router) {

    $router->bind('vehicles', function ($id) {
        return app('Modules\Transport\Repositories\VehiclesRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'admin.transport.vehicles.index',
        'uses' => 'VehiclesController@index',
        'middleware' => 'can:transport.vehicles.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.transport.vehicles.create',
        'uses' => 'VehiclesController@create',
        'middleware' => 'can:transport.vehicles.create'
    ]);
    $router->post('/', [
        'as' => 'admin.transport.vehicles.store',
        'uses' => 'VehiclesController@store',
        'middleware' => 'can:transport.vehicles.create'
    ]);
    $router->get('/{vehicles}/edit', [
        'as' => 'admin.transport.vehicles.edit',
        'uses' => 'VehiclesController@edit',
        'middleware' => 'can:transport.vehicles.edit'
    ]);
    $router->put('/{vehicles}', [
        'as' => 'admin.transport.vehicles.update',
        'uses' => 'VehiclesController@update',
        'middleware' => 'can:transport.vehicles.edit'
    ]);
    $router->delete('/{vehicles}', [
        'as' => 'admin.transport.vehicles.destroy',
        'uses' => 'VehiclesController@destroy',
        'middleware' => 'can:transport.vehicles.destroy'
    ]);

});
$router->group(['prefix' =>'/documents'], function (Router $router) {

    $router->bind('document', function ($id) {
        return app('Modules\Transport\Repositories\DocumentRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'admin.transport.document.index',
        'uses' => 'DocumentController@index',
        'middleware' => 'can:transport.documents.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.transport.document.create',
        'uses' => 'DocumentController@create',
        'middleware' => 'can:transport.documents.create'
    ]);
    $router->post('/', [
        'as' => 'admin.transport.document.store',
        'uses' => 'DocumentController@store',
        'middleware' => 'can:transport.documents.create'
    ]);
    $router->get('/{document}/edit', [
        'as' => 'admin.transport.document.edit',
        'uses' => 'DocumentController@edit',
        'middleware' => 'can:transport.documents.edit'
    ]);
    $router->put('/{document}', [
        'as' => 'admin.transport.document.update',
        'uses' => 'DocumentController@update',
        'middleware' => 'can:transport.documents.edit'
    ]);
    $router->delete('/{document}', [
        'as' => 'admin.transport.document.destroy',
        'uses' => 'DocumentController@destroy',
        'middleware' => 'can:transport.documents.destroy'
    ]);

});
$router->group(['prefix' =>'/drivers'], function (Router $router) {

    $router->bind('driver', function ($id) {
        return app('Modules\Transport\Repositories\DriverRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'admin.transport.driver.index',
        'uses' => 'DriverController@index',
        'middleware' => 'can:transport.drivers.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.transport.driver.create',
        'uses' => 'DriverController@create',
        'middleware' => 'can:transport.drivers.create'
    ]);
    $router->post('/', [
        'as' => 'admin.transport.driver.store',
        'uses' => 'DriverController@store',
        'middleware' => 'can:transport.drivers.create'
    ]);
    $router->get('/{driver}/edit', [
        'as' => 'admin.transport.driver.edit',
        'uses' => 'DriverController@edit',
        'middleware' => 'can:transport.drivers.edit'
    ]);
    $router->put('/{driver}', [
        'as' => 'admin.transport.driver.update',
        'uses' => 'DriverController@update',
        'middleware' => 'can:transport.drivers.edit'
    ]);
    $router->delete('/{driver}', [
        'as' => 'admin.transport.driver.destroy',
        'uses' => 'DriverController@destroy',
        'middleware' => 'can:transport.drivers.destroy'
    ]);

});

// append










});
