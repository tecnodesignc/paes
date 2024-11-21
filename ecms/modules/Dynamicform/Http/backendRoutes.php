<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/dynamicform'], function (Router $router) {
$router->group(['prefix' =>'/forms'], function (Router $router) {

   /* $router->bind('form', function ($id) {
        return app('Modules\Dynamicform\Repositories\FormRepository')->find($id);
    });*/

    $router->get('/', [
        'as' => 'admin.dynamicform.form.index',
        'uses' => 'FormController@index',
        'middleware' => 'can:dynamicform.forms.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.dynamicform.form.create',
        'uses' => 'FormController@create',
        'middleware' => 'can:dynamicform.forms.create'
    ]);
    $router->post('/', [
        'as' => 'admin.dynamicform.form.store',
        'uses' => 'FormController@store',
        'middleware' => 'can:dynamicform.forms.create'
    ]);
    $router->get('/{form}/edit', [
        'as' => 'admin.dynamicform.form.edit',
        'uses' => 'FormController@edit',
        'middleware' => 'can:dynamicform.forms.edit'
    ]);
    $router->put('/{form}', [
        'as' => 'admin.dynamicform.form.update',
        'uses' => 'FormController@update',
        'middleware' => 'can:dynamicform.forms.edit'
    ]);
    $router->delete('/{form}', [
        'as' => 'admin.dynamicform.form.destroy',
        'uses' => 'FormController@destroy',
        'middleware' => 'can:dynamicform.forms.destroy'
    ]);

});

$router->group(['prefix' =>'/fields'], function (Router $router) {

    $router->bind('field', function ($id) {
        return app('Modules\Dynamicform\Repositories\FieldRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'admin.dynamicform.field.index',
        'uses' => 'FieldController@index',
        'middleware' => 'can:dynamicform.fields.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.dynamicform.field.create',
        'uses' => 'FieldController@create',
        'middleware' => 'can:dynamicform.fields.create'
    ]);
    $router->post('/', [
        'as' => 'admin.dynamicform.field.store',
        'uses' => 'FieldController@store',
        'middleware' => 'can:dynamicform.fields.create'
    ]);
    $router->get('/{field}/edit', [
        'as' => 'admin.dynamicform.field.edit',
        'uses' => 'FieldController@edit',
        'middleware' => 'can:dynamicform.fields.edit'
    ]);
    $router->put('/{field}', [
        'as' => 'admin.dynamicform.field.update',
        'uses' => 'FieldController@update',
        'middleware' => 'can:dynamicform.fields.edit'
    ]);
    $router->delete('/{field}', [
        'as' => 'admin.dynamicform.field.destroy',
        'uses' => 'FieldController@destroy',
        'middleware' => 'can:dynamicform.fields.destroy'
    ]);

});

$router->group(['prefix' =>'/formresponses'], function (Router $router) {

    $router->bind('formresponse', function ($id) {
        return app('Modules\Dynamicform\Repositories\FormResponseRepository')->find($id);
    });

    $router->get('/', [
        'as' => 'admin.dynamicform.formresponse.index',
        'uses' => 'FormResponseController@index',
        'middleware' => 'can:dynamicform.formresponses.index'
    ]);
    $router->get('/create', [
        'as' => 'admin.dynamicform.formresponse.create',
        'uses' => 'FormResponseController@create',
        'middleware' => 'can:dynamicform.formresponses.create'
    ]);
    $router->post('/', [
        'as' => 'admin.dynamicform.formresponse.store',
        'uses' => 'FormResponseController@store',
        'middleware' => 'can:dynamicform.formresponses.create'
    ]);
    $router->get('/{formresponse}/edit', [
        'as' => 'admin.dynamicform.formresponse.edit',
        'uses' => 'FormResponseController@edit',
        'middleware' => 'can:dynamicform.formresponses.edit'
    ]);
    $router->put('/{formresponse}', [
        'as' => 'admin.dynamicform.formresponse.update',
        'uses' => 'FormResponseController@update',
        'middleware' => 'can:dynamicform.formresponses.edit'
    ]);
    $router->delete('/{formresponse}', [
        'as' => 'admin.dynamicform.formresponse.destroy',
        'uses' => 'FormResponseController@destroy',
        'middleware' => 'can:dynamicform.formresponses.destroy'
    ]);

});

// append



});
