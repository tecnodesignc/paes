<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/sass'], function (Router $router) {
$router->group(['prefix' =>'/companies'], function (Router $router) {

    $router->bind('company', function ($id) {
        return app('Modules\Sass\Repositories\CompanyRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'admin.sass.company.index',
        'uses' => 'CompanyController@index',
        'middleware' => 'can:sass.companies.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.sass.company.create',
        'uses' => 'CompanyController@create',
        'middleware' => 'can:sass.companies.create'
    ]);
    $router->post('/', [
        'as' => 'admin.sass.company.store',
        'uses' => 'CompanyController@store',
        'middleware' => 'can:sass.companies.create'
    ]);
    $router->get('/{company}/edit', [
        'as' => 'admin.sass.company.edit',
        'uses' => 'CompanyController@edit',
        'middleware' => 'can:sass.companies.edit'
    ]);
    $router->put('/{company}', [
        'as' => 'admin.sass.company.update',
        'uses' => 'CompanyController@update',
        'middleware' => 'can:sass.companies.edit'
    ]);
    $router->delete('/{company}', [
        'as' => 'admin.sass.company.destroy',
        'uses' => 'CompanyController@destroy',
        'middleware' => 'can:sass.companies.destroy'
    ]);

});

$router->group(['prefix' =>'/settings'], function (Router $router) {

    $router->bind('setting', function ($id) {
        return app('Modules\Sass\Repositories\SettingRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'admin.sass.setting.index',
        'uses' => 'SettingController@index',
        'middleware' => 'can:sass.settings.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.sass.setting.create',
        'uses' => 'SettingController@create',
        'middleware' => 'can:sass.settings.create'
    ]);
    $router->post('/', [
        'as' => 'admin.sass.setting.store',
        'uses' => 'SettingController@store',
        'middleware' => 'can:sass.settings.create'
    ]);
    $router->get('/{setting}/edit', [
        'as' => 'admin.sass.setting.edit',
        'uses' => 'SettingController@edit',
        'middleware' => 'can:sass.settings.edit'
    ]);
    $router->put('/{setting}', [
        'as' => 'admin.sass.setting.update',
        'uses' => 'SettingController@update',
        'middleware' => 'can:sass.settings.edit'
    ]);
    $router->delete('/{setting}', [
        'as' => 'admin.sass.setting.destroy',
        'uses' => 'SettingController@destroy',
        'middleware' => 'can:sass.settings.destroy'
    ]);

});

// append


});
