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

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', 'TaskController@index');
    Route::get('/tasks/{id}', 'TaskController@show')->name('tasks.show');
    Route::get('/tasks/next/{slug}', 'TaskController@nextTask')->name('tasks.next');
    Route::post('/tasks/{slug}/check_answer', 'TaskController@check_answer')->name('tasks.check_answers');
});
