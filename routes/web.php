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


/*Route::get('/hello', function(){
    //return view('welcome');
    return '<h1>Hello World</h1>';
});

Route::get('users/{id}/{name}', function($id, $name){
    return 'This user is '.$name.' with an ID of '.$id;
});

Route::get('/', function(){
    return view('welcome');
    //return '<h1>Hello World</h1>';
});
*/

/*Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/index', function () {
    return view('pages.index');
});

Route::get('/services', function() {
    return view('pages.services');
});
*/



Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Route::get('posts/{id}/cart', 'PostsController@cart');
Route::put('posts/{id}/{user_id}', 'PostsController@updateNew');
Route::resource('posts', 'PostsController');




Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
