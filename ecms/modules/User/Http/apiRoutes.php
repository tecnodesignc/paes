<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => 'auth'], function (Router $router) {
    $router->post('login', ['as' => 'login.post', 'uses' => 'AuthController@login']);
    # Register
    if (config('encore.user.config.allow_user_registration', true)) {
         $router->post('register', ['as' => 'api.register.post', 'uses' => 'AuthController@register']);
    }
    $router->post('reset', ['as' => 'reset.post', 'uses' => 'AuthController@reset']);
    $router->post('reset/complete', ['as' => 'api.reset.complete', 'uses' => 'AuthController@resetComplete']);
    # Logout
    $router->get('logout', ['as' => 'api.logout', 'uses' => 'AuthController@logout']);
});
$router->group(['prefix' => '/user', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->group(['prefix' => 'roles'], function (Router $router) {
        $router->get('/', [
            'as' => 'api.user.role.index',
            'uses' => 'RoleController@index',
            'middleware' => 'token-can:user.roles.index',
        ]);
        $router->get('all', [
            'as' => 'api.user.role.all',
            'uses' => 'RoleController@all',
            'middleware' => 'token-can:user.roles.index',
        ]);
        $router->post('/', [
            'as' => 'api.user.role.store',
            'uses' => 'RoleController@store',
            'middleware' => 'token-can:user.roles.create',
        ]);
        $router->post('find/{role}', [
            'as' => 'api.user.role.find',
            'uses' => 'RoleController@find',
            'middleware' => 'token-can:user.roles.edit',
        ]);
        $router->post('find-new', [
            'as' => 'api.user.role.find-new',
            'uses' => 'RoleController@findNew',
            'middleware' => 'token-can:user.roles.edit',
        ]);
        $router->post('{role}/edit', [
            'as' => 'api.user.role.update',
            'uses' => 'RoleController@update',
            'middleware' => 'token-can:user.roles.edit',
        ]);
        $router->delete('{role}', [
            'as' => 'api.user.role.destroy',
            'uses' => 'RoleController@destroy',
            'middleware' => 'token-can:user.roles.destroy',
        ]);
    });

    $router->group(['prefix' => 'users'], function (Router $router) {
        $router->get('/', [
            'as' => 'api.user.user.index',
            'uses' => 'UserController@index',
            'middleware' => 'token-can:user.users.index',
        ]);
        $router->post('/', [
            'as' => 'api.user.user.store',
            'uses' => 'UserController@store',
            'middleware' => 'token-can:user.users.create',
        ]);
        $router->post('find/{user}', [
            'as' => 'api.user.user.find',
            'uses' => 'UserController@find',
            'middleware' => 'token-can:user.users.edit',
        ]);
        $router->post('find-new', [
            'as' => 'api.user.user.find-new',
            'uses' => 'UserController@findNew',
            'middleware' => 'token-can:user.users.edit',
        ]);
        $router->post('{user}/edit', [
            'as' => 'api.user.user.update',
            'uses' => 'UserController@update',
            'middleware' => 'token-can:user.users.edit',
        ]);
        $router->get('{user}/sendResetPassword', [
            'as' => 'api.user.user.sendResetPassword',
            'uses' => 'UserController@sendResetPassword',
            'middleware' => 'token-can:user.users.edit',
        ]);
        $router->delete('{user}', [
            'as' => 'api.user.user.destroy',
            'uses' => 'UserController@destroy',
            'middleware' => 'token-can:user.users.destroy',
        ]);
    });

    $router->group(['prefix' => '/account'], function (Router $router) {
        $router->get('profile', [
            'as' => 'api.account.profile.find-current-user',
            'uses' => 'ProfileController@findCurrentUser',
        ]);
        $router->post('profile', [
            'as' => 'api.account.profile.update',
            'uses' => 'ProfileController@update',
        ]);

        $router->get('api-keys', [
            'as' => 'api.account.api.index',
            'uses' => 'ApiKeysController@index',
            'middleware' => 'can:account.api-keys.index',
        ]);
        $router->get('api-keys/create', [
            'as' => 'api.account.api.create',
            'uses' => 'ApiKeysController@create',
            'middleware' => 'can:account.api-keys.create',
        ]);
        $router->delete('api-keys/{userTokenId}', [
            'as' => 'api.account.api.destroy',
            'uses' => 'ApiKeysController@destroy',
            'middleware' => 'can:account.api-keys.destroy',
        ]);
    });

    $router->get('permissions', [
        'as' => 'api.user.permissions.index',
        'uses' => 'PermissionsController@index',
        'middleware' => 'token-can:user.roles.index',
    ]);
});
$router->group(['prefix' => '/user/v1'], function (Router $router) {
//======  AUTH
    require('ApiRoutes/authRoutes.php');

//======  ROLES
    require('ApiRoutes/roleRoutes.php');

//======  USERS
    require('ApiRoutes/userRoutes.php');

    $router->get('/permissions', [
        'as' => 'api.user.permissions',
        'uses' => 'PermissionsApiController@index',
        //'middleware' => ['auth:api']
    ]);
});
