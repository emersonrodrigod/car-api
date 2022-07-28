<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['namespace' => 'Api\V1', 'prefix' => 'api/v1'], function() use ($router) {
    $router->get('/users', 'UserController@index');
    $router->post('/users', 'UserController@store');
    $router->get('/users/{id}', 'UserController@show');
    $router->put('/users/{id}', 'UserController@update');
    $router->delete('/users/{id}', 'UserController@destroy');
    $router->post('/users/{id}/attach-car', 'UserController@attachCar');
    $router->post('/users/{id}/detach-car', 'UserController@detachCar');

    $router->get('/cars', 'CarController@index');
    $router->post('/cars', 'CarController@store');
    $router->get('cars/{id}', 'CarController@show');
    $router->put('/cars/{id}', 'CarController@update');
    $router->delete('/cars/{id}', 'CarController@destroy');
});
