<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/sass', 'middleware' => 'auth.admin'], function (Router $router) {
    $router->group(['prefix' => '/companies'], function (Router $router) {

        $router->bind('company', function ($id) {
            return app('Modules\Sass\Repositories\CompanyRepository')->find($id);
        });

        $router->get('/', [
            'as' => 'sass.company.index',
            'uses' => 'CompanyController@index',
            'middleware' => 'can:sass.companies.index'
        ]);
        $router->get('/create', [
            'as' => 'sass.company.create',
            'uses' => 'CompanyController@create',
            'middleware' => 'can:sass.companies.create'
        ]);
        $router->post('/', [
            'as' => 'sass.company.store',
            'uses' => 'CompanyController@store',
            'middleware' => 'can:sass.companies.create'
        ]);
        $router->get('/{company}/edit', [
            'as' => 'sass.company.edit',
            'uses' => 'CompanyController@edit',
            'middleware' => 'can:sass.companies.edit'
        ]);
        $router->get('/{id}/set', [
            'as' => 'sass.company.set',
            'uses' => 'CompanyController@setCompany',
            // 'middleware' => 'can:sass.companies.index'
        ]);
        $router->put('/{company}', [
            'as' => 'sass.company.update',
            'uses' => 'CompanyController@update',
            'middleware' => 'can:sass.companies.edit'
        ]);
        $router->delete('/{company}', [
            'as' => 'sass.company.destroy',
            'uses' => 'CompanyController@destroy',
            'middleware' => 'can:sass.companies.destroy'
        ]);

    });
});

$router->group(['prefix' => '/companies'], function (Router $router) {
    $router->get('settings', [
        'as' => 'sass.company.settings',
        'uses' => 'CompanyController@setting',
        'middleware' => 'can:sass.companies.edit'
    ]);
    $router->put('/update', [
        'as' => 'sass.company.settings.update',
        'uses' => 'CompanyController@settingUpdate',
        'middleware' => 'can:sass.companies.edit'
    ]);
    $router->group(['prefix' => '/drivers'], function (Router $router) {

        $router->get('register/{token_company}', [
            'as' => 'sass.drivers.register',
            'uses' => 'AuthController@getRegister'
        ]);
        $router->post('register', [
            'as' => 'sass.drivers.register.post',
            'uses' => 'AuthController@postRegister'
        ]);
        # Account Activation
        $router->get('activate/{userId}/{activationCode}',
            'AuthController@getActivate');
        # Reset password
        $router->get('reset', [
            'as' => 'sass.drivers.reset',
            'uses' => 'AuthController@getReset'
        ]);
        $router->post('reset', [
            'as' => 'sass.drivers.reset.post',
            'uses' => 'AuthController@postReset'
        ]);
        $router->get('reset/{id}/{code}', [
            'as' => 'sass.drivers.reset.complete',
            'uses' => 'AuthController@getResetComplete'
        ]);
        $router->post('reset/{id}/{code}', [
            'as' => 'sass.drivers.reset.complete.post',
            'uses' => 'AuthController@postResetComplete'
        ]);

    });
});
