<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'GroupsController@index')->name('admin.home');
    $router->resource('groups', GroupsController::class);
    $router->resource('tasks', TasksController::class);
    $router->resource('users', UsersController::class);
});
