<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/user/v1', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->group(['prefix' => '/api-keys'], function (Router $router) {
        $router->get('/create/{user_id}', [
            'as' => 'api.user.api.create',
            'uses' => 'ApiKeysController@create',
            'middleware' => 'can:account.api-keys.create',
        ]);
    });
});
