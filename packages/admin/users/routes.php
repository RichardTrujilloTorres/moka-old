<?php

Route::prefix(config('users.routes.prefix'))->group(function () {
    // Route::middleware(config('users.routes.middleware'))->group(function () {
    Route::middleware(['web', 'auth'])->group(function () {
        Route::namespace(config('users.routes.namespace'))->group(function () {
            Route::get('/', 'UsersController@index')->name('admin.users');
            Route::get('/{user}/edit', 'UsersController@edit')->name('admin.users.edit');
            Route::get('/{user}', 'UsersController@show')->name('admin.users.show');
            Route::put('/{user}', 'UsersController@update')->name('admin.users.update');


        });
    });
});


Route::get('/notify', 'Admin\Http\Controllers\UsersController@test');
