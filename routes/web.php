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

Route::get('/taskslist', 'TaskController@TasksList')->name("list");

Route::post('/edit', 'TaskController@TaskEdit');
Route::post('/pause', 'TaskController@TaskPause');
Route::post('/change', 'TaskController@TaskChange');
Route::post('/start', 'TaskController@TaskStart');
Route::post('/add', 'TaskController@TaskAdd');
Route::post('/reportpost', 'TaskController@TaskReportPost');

Route::get('/report', 'TaskController@TaskReport');

Route::get('/remove/{id}', 'TaskController@TaskRemove');

Route::get('/task/{id}', 'TaskController@Task');


Route::post('/register', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->middleware('selfauth');
Route::get('/home/edit', 'HomeController@edit')->middleware('selfauth');

Route::post('/home/loginpost', 'HomeController@loginPost');
Route::post('/home/passpost', 'HomeController@passwordPost');
Route::post('/home/avatarpost', 'HomeController@avatarPost');

