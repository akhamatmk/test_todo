<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'TodosController@index')->name('todo');
Route::get('/todo', 'TodosController@index')->name('todo');
Route::post('/todo/create', 'TodosController@create')->name('todo.create');
Route::post('/todo/destroy', 'TodosController@destroy')->name('todo.destroy');
