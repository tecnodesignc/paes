<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/traccar/auth'], function (Router $router) {
    $router->group(['prefix' =>'/login'], function (Router $router) {

        /*  $router->get('/', [
              'as' => 'api.apigpswox.token.index',
              'uses' => 'TokenApiController@index',
              'middleware' => ['auth:api']
          ]);*/

        $router->post('/', [
            'as' => 'api.apigpswox.token.store',
            'uses' => 'TokenApiController@store',
        ]);

        /*  $router->get('/{criteria}', [
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
          ]);*/

    });

});
$router->group(['prefix' =>'/apigpswox/v1','middleware' => ['api.token', 'auth.admin']], function (Router $router) {
$router->group(['prefix' =>'/tokens'], function (Router $router) {

  /*  $router->get('/', [
        'as' => 'api.apigpswox.token.index',
        'uses' => 'TokenApiController@index',
        'middleware' => ['auth:api']
    ]);*/

    $router->post('/', [
        'as' => 'api.apigpswox.token.store',
        'uses' => 'TokenApiController@store',
        'middleware' => ['token-can:apigpswox.tokens.store']
    ]);

  /*  $router->get('/{criteria}', [
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
    ]);*/

});
    $router->group(['prefix' =>'/devices'], function (Router $router) {

         $router->get('/', [
              'as' => 'api.traccar.device.index',
              'uses' => 'DeviceApiController@index',
              'middleware' => ['token-can:apigpswox.tokens.index']
          ]);
        $router->get('/{device_id}', [
            'as' => 'api.traccar.device.show',
            'uses' => 'DeviceApiController@show',
            'middleware' => ['token-can:apigpswox.tokens.index']
        ]);
        $router->get('/historic/{device_id}', [
            'as' => 'api.traccar.device.index',
            'uses' => 'DeviceApiController@historic',
            'middleware' => ['token-can:apigpswox.tokens.index']
        ]);
});

// append

});
