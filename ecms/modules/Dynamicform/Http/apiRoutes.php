<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/dynamicform/v1', 'middleware' => ['api.token', 'auth.admin']
], function (Router $router) {
    $router->group(['prefix' => '/forms'], function (Router $router) {
        $router->bind('form', function ($id) {
            return app('Modules\Dynamicform\Repositories\FormRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'api.dynamicform.form.index',
            'uses' => 'FormApiController@index',
            'middleware' => ['token-can:dynamicform.forms.index']
        ]);

        $router->post('/', [
            'as' => 'api.dynamicform.form.store',
            'uses' => 'FormApiController@store',
            'middleware' => ['token-can:dynamicform.forms.create']
        ]);

        $router->get('/{form}', [
            'as' => 'api.dynamicform.form.show',
            'uses' => 'FormApiController@show',
            'middleware' => ['token-can:dynamicform.forms.index']
        ]);
        $router->put('/{form}', [
            'as' => 'api.dynamicform.form.update',
            'uses' => 'FormController@update',
            'middleware' => ['token-can:dynamicform.forms.edit']
        ]);
        $router->delete('/{form}', [
            'as' => 'api.dynamicform.form.destroy',
            'uses' => 'FormApiController@destroy',
            'middleware' => ['token-can:dynamicform.forms.destroy']
        ]);

        $router->group(['prefix' => '/{form}/fields'], function (Router $router) {
            $router->bind('field', function ($id) {
                return app('Modules\Dynamicform\Repositories\FieldRepository')->find($id);
            });
            $router->get('/', [
                'as' => 'api.dynamicform.field.index',
                'uses' => 'FieldApiController@index',
                'middleware' => ['token-can:dynamicform.fields.index']
            ]);

            $router->post('/', [
                'as' => 'api.dynamicform.field.store',
                'uses' => 'FieldApiController@store',
                'middleware' => ['token-can:dynamicform.fields.create']
            ]);

            $router->get('/{field}', [
                'as' => 'api.dynamicform.field.show',
                'uses' => 'FieldApiController@show',
                'middleware' => ['token-can:dynamicform.fields.index']
            ]);
            $router->put('/{field}', [
                'as' => 'api.dynamicform.field.update',
                'uses' => 'FieldController@update',
                'middleware' => ['token-can:dynamicform.fields.edit']
            ]);
            $router->delete('/{field}', [
                'as' => 'api.dynamicform.field.destroy',
                'uses' => 'FieldApiController@destroy',
                'middleware' => ['token-can:dynamicform.fields.destroy']
            ]);

        });
    });
    $router->group(['prefix' => '/formresponses'], function (Router $router) {
        $router->bind('responses', function ($id) {
            return app('Modules\Dynamicform\Repositories\FormResponseRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'api.dynamicform.formresponse.index',
            'uses' => 'FormResponseApiController@index',
            'middleware' => ['token-can:dynamicform.formresponses.index']
        ]);
        $router->post('/', [
            'as' => 'api.dynamicform.formresponse.store',
            'uses' => 'FormResponseApiController@store',
            'middleware' => ['token-can:dynamicform.formresponses.index']
        ]);
        $router->post('/upload-image', [
            'as' => 'api.dynamicform.field.upload-image',
            'uses' => 'FormResponseApiController@uploadImage',
            'middleware' => ['token-can:dynamicform.formresponses.create']
        ]);
        $router->get('/{responses}', [
            'as' => 'api.dynamicform.formresponse.show',
            'uses' => 'FormResponseApiController@show',
            'middleware' => ['token-can:dynamicform.formresponses.create']
        ]);
        $router->put('/{responses}', [
            'as' => 'api.dynamicform.formresponse.update',
            'uses' => 'FormResponseController@update',
            'middleware' => ['token-can:dynamicform.formresponses.create']
        ]);
        $router->delete('/{responses}', [
            'as' => 'api.dynamicform.formresponse.destroy',
            'uses' => 'FormResponseApiController@destroy',
            'middleware' => ['token-can:dynamicform.formresponses.create']
        ]);

    });

    $router->group(['prefix' => '/vehicles'], function (Router $router) {
        $router->get('/{companyId}', [
            'as' => 'api.dynamicform.formresponse.vehicles',
            'uses' => 'FormResponseApiController@vehicles',
            'middleware' => ['token-can:dynamicform.formresponses.create']
        ]);
    });



// append


});
