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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();


Route::resource('threads', 'ThreadsController')->except(['show', 'delete']);
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');

Route::get('threads/{channel}', 'ChannelsController@index')->name('sort.channel');

Route::resource('replies', 'RepliesController')->only(['update', 'destroy']);
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('replies.store');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index')->name('replies.index');

Route::post('/replies/{reply}/favourites', 'FavouritesController@store')->name('favourites.reply');
Route::delete('/replies/{reply}/favourites', 'FavouritesController@destroy')->name('unfavourites.reply');

Route::get('/profile/{user}', 'ProfilesController@show')->name('profiles.show');
