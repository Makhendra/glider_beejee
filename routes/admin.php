<?php

Route::get('/', 'GroupsController@index');
Route::get('/login', 'LoginController@login');
Route::resource('groups', GroupsController::class);