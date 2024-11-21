<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/maintenance'], function (Router $router) {
$router->group(['prefix' =>'/events'], function (Router $router) {

    $router->bind('event', function ($id) {
        return app('Modules\Maintenance\Repositories\EventRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'admin.maintenance.event.index',
        'uses' => 'EventController@index',
        'middleware' => 'can:maintenance.events.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.maintenance.event.create',
        'uses' => 'EventController@create',
        'middleware' => 'can:maintenance.events.create'
    ]);
    $router->post('/', [
        'as' => 'admin.maintenance.event.store',
        'uses' => 'EventController@store',
        'middleware' => 'can:maintenance.events.create'
    ]);
    $router->get('/{event}/edit', [
        'as' => 'admin.maintenance.event.edit',
        'uses' => 'EventController@edit',
        'middleware' => 'can:maintenance.events.edit'
    ]);
    $router->put('/{event}', [
        'as' => 'admin.maintenance.event.update',
        'uses' => 'EventController@update',
        'middleware' => 'can:maintenance.events.edit'
    ]);
    $router->delete('/{event}', [
        'as' => 'admin.maintenance.event.destroy',
        'uses' => 'EventController@destroy',
        'middleware' => 'can:maintenance.events.destroy'
    ]);

});

$router->group(['prefix' =>'/fueltanks'], function (Router $router) {

    $router->bind('fueltank', function ($id) {
        return app('Modules\Maintenance\Repositories\FueltankRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'admin.maintenance.fueltank.index',
        'uses' => 'FueltankController@index',
        'middleware' => 'can:maintenance.fueltanks.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.maintenance.fueltank.create',
        'uses' => 'FueltankController@create',
        'middleware' => 'can:maintenance.fueltanks.create'
    ]);
    $router->post('/', [
        'as' => 'admin.maintenance.fueltank.store',
        'uses' => 'FueltankController@store',
        'middleware' => 'can:maintenance.fueltanks.create'
    ]);
    $router->get('/{fueltank}/edit', [
        'as' => 'admin.maintenance.fueltank.edit',
        'uses' => 'FueltankController@edit',
        'middleware' => 'can:maintenance.fueltanks.edit'
    ]);
    $router->put('/{fueltank}', [
        'as' => 'admin.maintenance.fueltank.update',
        'uses' => 'FueltankController@update',
        'middleware' => 'can:maintenance.fueltanks.edit'
    ]);
    $router->delete('/{fueltank}', [
        'as' => 'admin.maintenance.fueltank.destroy',
        'uses' => 'FueltankController@destroy',
        'middleware' => 'can:maintenance.fueltanks.destroy'
    ]);

});

// append


});
