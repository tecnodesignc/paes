<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/maintenance'], function (Router $router) {
$router->group(['prefix' =>'/events'], function (Router $router) {

    $router->bind('event', function ($id) {
        return app('Modules\Maintenance\Repositories\EventRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'maintenance.event.index',
        'uses' => 'EventController@index',
        'middleware' => 'can:maintenance.events.index'
    ]);
    $router->get('done/{event}', [
        'as' => 'maintenance.event.done',
        'uses' => 'EventController@done',
        'middleware' => 'can:maintenance.events.edit'
    ]);
    $router->put('/{event}', [
        'as' => 'maintenance.event.update',
        'uses' => 'EventController@update',
        'middleware' => 'can:maintenance.events.edit'
    ]);

});

// append


});
