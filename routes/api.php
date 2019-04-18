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

Route::group(['prefix' => 'auth'], function ($router) {
    $router->post('login', 'Api\AuthController@login');
    $router->post('logout', 'Api\AuthController@logout');
    $router->post('refresh', 'Api\AuthController@refresh');
    Route::middleware('refresh.token')->group(function($router) {
        $router->post('profile', 'Api\AuthController@profile');
    });  
});
Route::Resource('article', 'Api\ArticleController');
Route::delete('article', 'Api\ArticleController@destroyAll');

