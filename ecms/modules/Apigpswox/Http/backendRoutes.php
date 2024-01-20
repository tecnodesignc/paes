<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/apigpswox'], function (Router $router) {
$router->group(['prefix' =>'/tokens'], function (Router $router) {

    $router->bind('token', function ($id) {
        return app('Modules\Apigpswox\Repositories\TokenRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'admin.apigpswox.token.index',
        'uses' => 'TokenController@index',
        'middleware' => 'can:apigpswox.tokens.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.apigpswox.token.create',
        'uses' => 'TokenController@create',
        'middleware' => 'can:apigpswox.tokens.create'
    ]);
    $router->post('/', [
        'as' => 'admin.apigpswox.token.store',
        'uses' => 'TokenController@store',
        'middleware' => 'can:apigpswox.tokens.create'
    ]);
    $router->get('/{token}/edit', [
        'as' => 'admin.apigpswox.token.edit',
        'uses' => 'TokenController@edit',
        'middleware' => 'can:apigpswox.tokens.edit'
    ]);
    $router->put('/{token}', [
        'as' => 'admin.apigpswox.token.update',
        'uses' => 'TokenController@update',
        'middleware' => 'can:apigpswox.tokens.edit'
    ]);
    $router->delete('/{token}', [
        'as' => 'admin.apigpswox.token.destroy',
        'uses' => 'TokenController@destroy',
        'middleware' => 'can:apigpswox.tokens.destroy'
    ]);

});

// append

});
