<?php
use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/preoperativo','middleware' => 'auth.admin'], function (Router $router) {
    $router->get('/', [
        'as' => 'dynamicform.dashboard',
        'uses' => 'PublicController@dashboard',
    ]);
    $router->group(['prefix' =>'/form'], function (Router $router) {
        $router->get('/', [
            'as' => 'dynamicform.form.index',
            'uses' => 'FormController@index',
            'middleware' => 'can:dynamicform.forms.index'
        ]);
        $router->get('/create', [
            'as' => 'dynamicform.form.create',
            'uses' => 'FormController@create',
            'middleware' => 'can:dynamicform.forms.create'
        ]);
        $router->post('/', [
            'as' => 'dynamicform.form.store',
            'uses' => 'FormController@store',
            'middleware' => 'can:dynamicform.forms.create'
        ]);
        $router->get('/{form}/edit', [
            'as' => 'dynamicform.form.edit',
            'uses' => 'FormController@edit',
            'middleware' => 'can:dynamicform.forms.edit'
        ]);
        $router->put('/{form}', [
            'as' => 'dynamicform.form.update',
            'uses' => 'FormController@update',
            'middleware' => 'can:dynamicform.forms.edit'
        ]);
        $router->delete('/{form}', [
            'as' => 'dynamicform.form.destroy',
            'uses' => 'FormController@destroy',
            'middleware' => 'can:dynamicform.forms.destroy'
        ]);
        $router->group(['prefix' =>'/{form}/field'], function (Router $router) {
            $router->get('/create', [
                'as' => 'dynamicform.field.create',
                'uses' => 'FieldController@create',
                'middleware' => 'can:dynamicform.fields.create'
            ]);
            $router->post('/', [
                'as' => 'dynamicform.field.store',
                'uses' => 'FieldController@store',
                'middleware' => 'can:dynamicform.fields.create'
            ]);
            $router->get('/{field}/edit', [
                'as' => 'dynamicform.field.edit',
                'uses' => 'FieldController@edit',
                'middleware' => 'can:dynamicform.fields.edit'
            ]);
            $router->put('/{field}', [
                'as' => 'dynamicform.field.update',
                'uses' => 'FieldController@update',
                'middleware' => 'can:dynamicform.fields.edit'
            ]);
            $router->delete('/{field}', [
                'as' => 'dynamicform.field.destroy',
                'uses' => 'FieldController@destroy',
                'middleware' => 'can:dynamicform.fields.destroy'
            ]);
        });
        $router->group(['prefix' =>'/{form}/response'], function (Router $router) {
            $router->bind('form_response', function ($id) {
                return app('Modules\Dynamicform\Repositories\FormResponseRepository')->find($id);
            });
            $router->get('/{form_response}/edit', [
                'as' => 'dynamicform.formresponses.edit',
                'uses' => 'ResponseController@edit',
                'middleware' => 'can:dynamicform.formresponses.edit'
            ]);

            $router->get('/{form_response}/pdf', [
                'as' => 'dynamicform.formresponses.pdf',
                'uses' => 'ResponseController@download',
                'middleware' => 'can:dynamicform.formresponses.edit'
            ]);
        });
    });
});
