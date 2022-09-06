<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

use App\Http\Controllers\UserController;

$router->post('/register', 'UserController@postRegister');
$router->post('/login', 'UserController@postLogin');

$router->get('/', function () {
    return view('Homepage', ['name' => null]);
});

$router->get('/page/register', function () {
    return view('register');
});

$router->get('/page/login', function () {
    return view('login');
});


// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });