<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/transport/v1','middleware' => ['api.token', 'auth.admin']], function (Router $router) {
$router->group(['prefix' =>'/vehicles','middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->bind('vehicle', function ($id) {
        return app('Modules\Transport\Repositories\VehiclesRepository')->find($id);
    });
    $router->get('/', [
        'as' => 'api.transport.vehicles.index',
        'uses' => 'VehiclesApiController@index',
        'middleware' => ['token-can:transport.vehicles.index']
    ]);

    $router->post('/', [
        'as' => 'api.transport.vehicles.store',
        'uses' => 'VehiclesApiController@store',
        'middleware' => ['token-can:transport.vehicles.create']
    ]);

    $router->get('/{vehicle}', [
        'as' => 'api.transport.vehicles.show',
        'uses' => 'VehiclesApiController@show',
        'middleware' => ['token-can:transport.vehicles.index']
    ]);
    $router->put('/{vehicle}', [
        'as' => 'api.transport.vehicles.update',
        'uses' => 'VehiclesApiController@update',
        'middleware' => ['token-can:transport.vehicles.edit']
    ]);
    $router->delete('/{vehicle}', [
        'as' => 'api.transport.vehicles.destroy',
        'uses' => 'VehiclesApiController@destroy',
        'middleware' => ['token-can:transport.vehicles.destroy']
    ]);

});

$router->group(['prefix' =>'/documents','middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->bind('document', function ($id) {
        return app('Modules\Transport\Repositories\DocumentRepository')->find($id);
    });
    $router->get('/', [
        'as' => 'api.transport.document.index',
        'uses' => 'DocumentApiController@index',
        'middleware' => ['token-can:transport.documents.index']
    ]);

    $router->post('/', [
        'as' => 'api.transport.document.store',
        'uses' => 'DocumentApiController@store',
        'middleware' => ['token-can:transport.documents.create']
    ]);

    $router->get('/{document}', [
        'as' => 'api.transport.document.show',
        'uses' => 'DocumentApiController@show',
        'middleware' => ['token-can:transport.documents.index']
    ]);
    $router->put('/{document}', [
        'as' => 'api.transport.document.update',
        'uses' => 'DocumentApiController@update',
        'middleware' => ['token-can:transport.documents.edit']
    ]);
    $router->delete('/{document}', [
        'as' => 'api.transport.document.destroy',
        'uses' => 'DocumentApiController@destroy',
        'middleware' => ['token-can:transport.documents.destroy']
    ]);

});

$router->group(['prefix' =>'/drivers','middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->bind('driver', function ($id) {
        return app('Modules\Transport\Repositories\DriverRepository')->with('user')->find($id);
    });
    $router->get('/', [
        'as' => 'api.transport.driver.index',
        'uses' => 'DriverApiController@index',
        'middleware' => ['token-can:transport.drivers.index']
    ]);

    $router->post('/', [
        'as' => 'api.transport.driver.store',
        'uses' => 'DriverApiController@store',
        'middleware' => ['token-can:transport.drivers.create']
    ]);

    $router->get('/{driver}', [
        'as' => 'api.transport.driver.show',
        'uses' => 'DriverApiController@show',
        'middleware' => ['token-can:transport.drivers.index']
    ]);
    $router->put('/{driver}', [
        'as' => 'api.transport.driver.update',
        'uses' => 'DriverApiController@update',
        'middleware' => ['token-can:transport.drivers.edit']
    ]);
    $router->delete('/{driver}', [
        'as' => 'api.transport.driver.destroy',
        'uses' => 'DriverApiController@destroy',
        'middleware' => ['token-can:transport.drivers.destroy']
    ]);

});

// append










});
