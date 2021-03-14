<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users/register', 'UserController@create');

Route::post('/users/login', 'UserController@login');

Route::put('/users/logout/{token}', 'UserController@logout');

Route::middleware(['check.auth','check.permission'])->group(function () {

	Route::get('/comments/index', 'CommentController@index');

	Route::post('/comments/create', 'CommentController@create');

	Route::put('/comments/update/{id}', 'CommentController@update');

	Route::delete('/comments/delete/{id}', 'CommentController@delete');

	Route::get('/posts/index', 'PostController@index');

	Route::post('/posts/create', 'PostController@create');

	Route::put('/posts/update/{id}', 'PostController@update');

	Route::delete('/posts/delete/{id}', 'PostController@delete');

});

