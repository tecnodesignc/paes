<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/apigpswox/v1'], function (Router $router) {
$router->group(['prefix' =>'/tokens'], function (Router $router) {

    $router->get('/', [
        'as' => 'api.apigpswox.token.index',
        'uses' => 'TokenApiController@index',
        'middleware' => ['auth:api']
    ]);

    $router->post('/', [
        'as' => 'api.apigpswox.token.store',
        'uses' => 'TokenApiController@store',
        'middleware' => ['auth:api']
    ]);

    $router->get('/{criteria}', [
        'as' => 'api.apigpswox.token.show',
        'uses' => 'TokenApiController@show',
        'middleware' => ['auth:api']
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.apigpswox.token.update',
        'uses' => 'TokenController@update',
        'middleware' => ['auth:api']
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.apigpswox.token.destroy',
        'uses' => 'TokenApiController@destroy',
        'middleware' => ['auth:api']
    ]);

});

// append

});
