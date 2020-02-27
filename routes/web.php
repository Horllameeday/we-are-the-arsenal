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

/*Route::get('/', function () {
    //return view('welcome');
    return '<h1>Hello World</h1>';
});*/
Route::get('/', 'PageController@index')->name('home');
Route::get('/home', 'PageController@index');
//Route::get('/about', 'PagesController@about');
//Route::get('/services', 'PagesController@services');

Route::resource('posts', 'PostController', ['except' => [
    'show', 'edit', 'like', 'comment'
]]);
Route::get('/posts/{slug}', 'PostController@show')->name('posts.show');
Route::get('/posts/{slug}/edit', 'PostController@edit')->name('posts.edit');
Route::get('/posts/{slug}/like', 'PostController@like')->name('posts.like');
Route::post('/posts/{slug}/comment', 'PostController@comment')->name('posts.comment');
Auth::routes();

//Route::get('/dashboard', 'DashboardController@index');

