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

$router->get('/key', function() {
    return str_random(32);
});

$router->get('account', [
    'as' => 'acc', 'uses' => 'AccountController@index'
]);

$router->get('detail/{accno}/{pin}', [
    'as' => 'dtl', 'uses' => 'AccountController@show'
]);

$router->post('transaksi', [
    'as' => 'trans', 'uses' => 'AccountController@transaksi'
]);