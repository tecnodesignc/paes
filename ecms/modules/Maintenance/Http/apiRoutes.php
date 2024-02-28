<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/maintenance/v1','middleware' => ['api.token', 'auth.admin']], function (Router $router) {
$router->group(['prefix' =>'/events'], function (Router $router) {

    $router->get('/', [
        'as' => 'api.maintenance.event.index',
        'uses' => 'EventApiController@index',
        'middleware' => ['token-can:maintenance.events.index']
    ]);

    $router->post('/', [
        'as' => 'api.maintenance.event.store',
        'uses' => 'EventApiController@store',
        'middleware' => ['token-can:maintenance.events.index']
    ]);

    $router->get('/{event}', [
        'as' => 'api.maintenance.event.show',
        'uses' => 'EventApiController@show',
        'middleware' => ['token-can:maintenance.events.create']
    ]);
    $router->put('/{event}', [
        'as' => 'api.maintenance.event.update',
        'uses' => 'EventApiController@update',
        'middleware' => ['token-can:maintenance.events.edit']
    ]);
    $router->delete('/{event}', [
        'as' => 'api.maintenance.event.destroy',
        'uses' => 'EventApiController@destroy',
        'middleware' => ['token-can:maintenance.events.destroy']
    ]);

});

$router->group(['prefix' =>'/fueltanks'], function (Router $router) {

    $router->get('/', [
        'as' => 'api.maintenance.fueltank.index',
        'uses' => 'FueltankApiController@index',
        'middleware' => ['token-can:maintenance.fueltanks.index']
    ]);

    $router->post('/', [
        'as' => 'api.maintenance.fueltank.store',
        'uses' => 'FueltankApiController@store',
        'middleware' => ['token-can:maintenance.fueltanks.index']
    ]);

    $router->get('/{criteria}', [
        'as' => 'api.maintenance.fueltank.show',
        'uses' => 'FueltankApiController@show',
        'middleware' => ['token-can:maintenance.fueltanks.create']
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.maintenance.fueltank.update',
        'uses' => 'FueltankController@update',
        'middleware' => ['token-can:maintenance.fueltanks.edit']
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.maintenance.fueltank.destroy',
        'uses' => 'FueltankApiController@destroy',
        'middleware' => ['token-can:maintenance.fueltanks.destroy']
    ]);

});

$router->group(['prefix' =>'/tires'], function (Router $router) {
    $router->bind('tire', function ($id) {
        return app('Modules\Maintenance\Repositories\TireRepository')->find($id);
    });
    $router->get('/', [
        'as' => 'api.maintenance.tire.index',
        'uses' => 'TireApiController@index',
       'middleware' => ['token-can:maintenance.tires.index']
    ]);

    $router->post('/', [
        'as' => 'api.maintenance.tire.store',
        'uses' => 'TireApiController@store',
        'middleware' => ['auth:api']
    ]);

    $router->get('/{tire}', [
        'as' => 'api.maintenance.tire.show',
        'uses' => 'TireApiController@show',
        'middleware' => ['token-can:maintenance.tires.create']
    ]);
    $router->put('/{tire}', [
        'as' => 'api.maintenance.tire.update',
        'uses' => 'TireController@update',
        'middleware' => ['auth:api']
    ]);
    $router->delete('/{tire}', [
        'as' => 'api.maintenance.tire.destroy',
        'uses' => 'TireApiController@destroy',
        'middleware' => ['auth:api']
    ]);

});

// append



});
