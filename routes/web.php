<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/employees',['as' => 'showAllEmployees', 'uses' => 'EmployeeController@index']);
$router->post('/employees',['as' => 'createAnEmployee', 'uses' => 'EmployeeController@store']);
$router->get("/employees/{id}",['as' => 'showAnEmployee', 'uses' => 'EmployeeController@show', function ($id) { }]);
$router->put("/employees/{id}",['as' => 'updateAnEmployee', 'uses' => 'EmployeeController@update', function ($id) { }]);
$router->patch("/employees/{id}",['as' => 'updateAnEmployee', 'uses' => 'EmployeeController@update', function ($id) { }]);
$router->delete("/employees/{id}",['as' => 'deleteAnEmployee', 'uses' => 'EmployeeController@destroy', function ($id) { }]);
