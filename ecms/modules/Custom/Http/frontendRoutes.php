<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/user'], function (Router $router) {
    $router->bind('user', function ($id) {
        return app('Modules\User\Repositories\Sentinel\SentinelUserRepository')->find($id);
    });
    $router->get('users', [
        'as' => 'user.user.index',
        'uses' => 'UserController@index',
        'middleware' => 'can:user.users.index',
    ]);
    $router->get('users/create', [
        'as' => 'user.user.create',
        'uses' => 'UserController@create',
        'middleware' => 'can:user.users.create',
    ]);
    $router->post('users', [
        'as' => 'user.user.store',
        'uses' => 'UserController@store',
        'middleware' => 'can:user.users.create',
    ]);
    $router->get('users/{users}/edit', [
        'as' => 'user.user.edit',
        'uses' => 'UserController@edit',
        'middleware' => 'can:user.users.edit',
    ]);
    $router->put('users/{users}/edit', [
        'as' => 'user.user.update',
        'uses' => 'UserController@update',
        'middleware' => 'can:user.users.edit',
    ]);
    $router->get('users/{users}/sendResetPassword', [
        'as' => 'user.user.sendResetPassword',
        'uses' => 'UserController@sendResetPassword',
        'middleware' => 'can:user.users.edit',
    ]);
    $router->delete('users/{users}', [
        'as' => 'user.user.destroy',
        'uses' => 'UserController@destroy',
        'middleware' => 'can:user.users.destroy',
    ]);
    $router->bind('role', function ($id) {
        return app('Modules\User\Repositories\RoleRepository')->find($id);
    });
    $router->get('roles', [
        'as' => 'user.role.index',
        'uses' => 'RolesController@index',
        'middleware' => 'can:user.roles.index',
    ]);
    $router->get('roles/create', [
        'as' => 'user.role.create',
        'uses' => 'RolesController@create',
        'middleware' => 'can:user.roles.create',
    ]);
    $router->post('roles', [
        'as' => 'user.role.store',
        'uses' => 'RolesController@store',
        'middleware' => 'can:user.roles.create',
    ]);
    $router->get('roles/{role}/edit', [
        'as' => 'user.role.edit',
        'uses' => 'RolesController@edit',
        'middleware' => 'can:user.roles.edit',
    ]);
    $router->put('roles/{role}/edit', [
        'as' => 'user.role.update',
        'uses' => 'RolesController@update',
        'middleware' => 'can:user.roles.edit',
    ]);
    $router->delete('roles/{role}', [
        'as' => 'user.role.destroy',
        'uses' => 'RolesController@destroy',
        'middleware' => 'can:user.roles.destroy',
    ]);
});
$router->group(['prefix' => '/account'], function (Router $router) {

    $router->get('profile', [
        'as' => 'account.profile.view',
        'uses' => 'Account\ProfileController@edit',
    ]);
    $router->put('profile', [
        'as' => 'account.profile.update',
        'uses' => 'Account\ProfileController@update',
    ]);
    $router->get('api-keys', [
        'as' => 'account.api.index',
        'uses' => 'Account\ApiKeysController@index',
        'middleware' => 'can:account.api-keys.index',
    ]);
    $router->get('api-keys/create', [
        'as' => 'account.api.create',
        'uses' => 'Account\ApiKeysController@create',
        'middleware' => 'can:account.api-keys.create',
    ]);
    $router->delete('api-keys/{userTokenId}', [
        'as' => 'account.api.destroy',
        'uses' => 'Account\ApiKeysController@destroy',
        'middleware' => 'can:account.api-keys.destroy',
    ]);
});

$router->group(['prefix'=>'/sms'], function (Router $router){
    $router->get('send', [
        'as' => 'sms.send',
        'uses' => 'PublicController@send',
    ]);

});
