<?php

use Illuminate\Http\Request;

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

/**
 * @User related
 */

Route::get('authors', 'Api\UserController@index');
Route::get('authors/{id}', 'Api\UserController@show');
Route::get('posts/author/{id}', 'Api\UserController@posts');
Route::get('comments/author/{id}', 'Api\UserController@comments');

/**
 * @Posts related
 */

 Route::get('categories', 'Api\CategoryController@index');
 Route::get('posts/categories/{id}', 'Api\CategoryController@posts');
 Route::get('posts', 'Api\PostController@index');
 Route::get('posts/{id}', 'Api\PostController@show');

 Route::get('comments', 'Api\CommentController@index');
 Route::get('comments/posts/{id}', 'Api\CommentController@comments');
 Route::get('comments/{id}', 'Api\CommentController@show');

 // End Get related api

 /**
 * Start Posts Request
 */

 Route::post('register', 'Api\UserController@store');
 Route::post('token', 'Api\UserController@getToken');

 /**
 * End Posts Request
 */


Route::middleware('auth:api')->group(function () {
    Route::post('update-user/{id}', 'Api\UserController@update');
    Route::post('posts', 'Api\PostController@store');
    Route::post('posts/{id}', 'Api\PostController@update');
    Route::post('posts/delete/{id}', 'Api\PostController@destroy');
});
