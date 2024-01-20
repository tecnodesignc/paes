<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/sass'], function (Router $router) {
$router->group(['prefix' =>'/companies'], function (Router $router) {

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

$router->group(['prefix' =>'/companies'],function (Router $router){
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
});
