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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->GET('/paspor', ['uses' => 'AlgoController@GetDay']);
$router->post('/KasirSwalayan', ['uses' => 'AlgoController@KasirSwalayan']);
$router->post('/ocr', ['uses' => 'AlgoController@ocr']);
$router->GET('/raja', ['uses' => 'AlgoController@RajaOngkir']);
$router->GET('/excel', ['uses' => 'ExcelController@index']);
