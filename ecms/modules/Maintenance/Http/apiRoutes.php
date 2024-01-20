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

// append


});
