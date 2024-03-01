<?php
use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/preoperativo','middleware' => 'auth.admin'], function (Router $router) {
    $router->get('/', [
        'as' => 'dynamicform.dashboard',
        'uses' => 'PublicController@dashboard',
    ]);
    // Rutas relacionadas con los formularios
    $router->group(['prefix' =>'/form'], function (Router $router) {
        $router->get('/', [
            'as' => 'dynamicform.form.index',
            'uses' => 'FormController@index',
            'middleware' => 'can:dynamicform.forms.index'
        ]);
        $router->get('/colaboradores', [
            'as' => 'dynamicform.form.indexcolaboradoresform',
            'uses' => 'FormController@indexcolaboradoresform',
            'middleware' => 'can:dynamicform.formresponses.index'
        ]);
        $router->get('/{form}/show', [
            'as' => 'dynamicform.form.show',
            'uses' => 'FormController@show',
            'middleware' => 'can:dynamicform.formresponses.index'
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
        $router->put('/{form}/borrar', [
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
            $router->delete('/{field}/borrar', [
                'as' => 'dynamicform.field.destroy',
                'uses' => 'FieldController@destroy',
                'middleware' => 'can:dynamicform.fields.destroy'
            ]);
            // METODO PUT SI ES OK RENDERIZAR LA TABLA
            $router->put('/{field}/orden/{orden}', [
                'as' => 'dynamicform.field.orden',
                'uses' => 'FieldController@orden',
                'middleware' => 'can:dynamicform.fields.edit'
            ]);
            $router->post('/import', [
                'as' => 'dynamicform.field.import',
                'uses' => 'FieldController@import',
                // 'middleware' => 'can:dynamicform.fields.create'
            ]);

        });

        // Rutas de las respuesta de los formularios
        $router->group(['prefix' =>'/{form}/response'], function (Router $router) {

            $router->bind('form_response', function ($id) {
                return app('Modules\Dynamicform\Repositories\FormResponseRepository')->find($id);
            });

            $router->get('/', [
                'as' => 'dynamicform.formresponses.index',
                'uses' => 'ResponseController@index',
                'middleware' => 'can:dynamicform.formresponses.index'
            ]);

            $router->get('/{form_response}/show', [
                'as' => 'dynamicform.formresponses.show',
                'uses' => 'ResponseController@show',
                'middleware' => 'can:dynamicform.formresponses.edit'
            ]);

            $router->get('/create', [
                'as' => 'dynamicform.formresponses.create',
                'uses' => 'ResponseController@create',
                'middleware' => 'can:dynamicform.formresponses.create'
            ]);

            $router->post('/', [
                'as' => 'dynamicform.formresponses.store',
                'uses' => 'ResponseController@store',
                'middleware' => 'can:dynamicform.formresponses.create'
            ]);

            $router->get('/{form_response}/pdf', [
                'as' => 'dynamicform.formresponses.downloadpdf',
                'uses' => 'ResponseController@downloadpdf',
                // 'middleware' => 'can:dynamicform.formresponses.edit'
            ]);
        });
    });
});
