<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    dd(explode('_', 'Foo_james'));
    dd('foo' == 'FOO');
});

Route::post('login', 'AuthController@login');

Route::get('titles', 'MovieController@getTitles');