<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* @var \Illuminate\Routing\Router $router */
$router->get('/', 'WelcomeController')->name('welcome');
$router->get('home', 'HomeController')->name('home');
$router->auth(['register' => false]);
$router->resource('contacts', 'ContactController');
