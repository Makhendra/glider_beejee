<?php

use Illuminate\Support\Facades\Route;

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

use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::get('/', function (){return redirect()->route('groups.index');});
//Route::get('/exec-error/{data}', function ($data) {
//    $output = new \Symfony\Component\Console\Output\BufferedOutput;
//
//    try {
//        Artisan::call('migrate', array(), $output);
//    } catch (Exception $e) {
//        throw Exception($e->getMessage());
//    }
//
//    return $output->fetch();
//});
Route::post('report-bug', 'Controller@makeReport')->name('report_bug');
Route::get('lk', 'Controller@lk')->name('lk')->middleware('auth');
Route::group(
    ['prefix' => 'groups', 'middleware' => 'auth'],
    function () {
        Route::get('/', 'GroupsController@index')->name('groups.index');
        Route::get('/{group_id}/tasks', 'TaskController@index')->name('groups.tasks');
        Route::get('/tasks/{id}', 'TaskController@show')->name('tasks.show');
        Route::get('/tasks/next/{slug}', 'TaskController@nextTask')->name('tasks.next');
        Route::post('/tasks/{slug}/check_answer', 'TaskController@check_answer')->name(
            'tasks.check_answers'
        );
    }
);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
