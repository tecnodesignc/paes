<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/batchs','middleware' => ['auth:api']], function (Router $router) {
  
  $router->post('/move', [
    'as' => 'api.media.batchs.move',
    'uses' => 'NewApi\BatchApiController@move',
    'middleware' => 'auth-can:media.batchs.move'
  ]);
  
  $router->post('/destroy', [
    'as' => 'api.media.batchs.destroy',
    'uses' => 'NewApi\BatchApiController@destroy',
    'middleware' => 'auth-can:media.batchs.destroy'
  ]);

});