<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->post('notification/mark-read', ['as' => 'api.notification.read', 'uses' => 'NotificationsController@markAsRead']);
$router->group(['prefix' => 'notification',  'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    //Route create
    $router->post('/', [
        'as' => 'api.notification.notification.create',
        'uses' => 'NotificationsController@create',
        'middleware' => 'can:notification.notifications.create',
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.notification.notification.index',
        'uses' => 'NotificationsController@index',
        'middleware' => 'can:notification.notifications.index',
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.notification.notification.show',
        'uses' => 'NotificationsController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.notification.notification.update',
        'uses' => 'NotificationsController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.notification.notification.delete',
        'uses' => 'NotificationsController@delete',
        'middleware' => ['auth:api']
    ]);

});
