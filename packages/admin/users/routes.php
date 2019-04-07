<?php

Route::prefix(config('users.routes.prefix'))->group(function () {
    Route::middleware(config('users.routes.middleware', 'web'))->group(function () {
        // Route::middleware(['web', 'auth'])->group(function () {
        Route::namespace(config('users.routes.namespace'))->group(function () {

            // TODO rebuild as a resource
            Route::get('/', 'UsersController@index')->name('admin.users.index');
            Route::get('/{user}/edit', 'UsersController@edit')->name('admin.users.edit');
            Route::get('/{user}', 'UsersController@show')->name('admin.users.show');
            Route::put('/{user}', 'UsersController@update')->name('admin.users.update');
            Route::delete('/{user}', 'UsersController@destroy')->name('admin.users.delete');

            // @todo change to PUT
            Route::get('/{user}/lock', 'UsersController@lock')->name('admin.users.lock');
            Route::get('/{user}/unlock', 'UsersController@unlock')->name('admin.users.unlock');

            Route::put('/{user}/image', 'UsersController@setProfileImage')->name('admin.users.setProfileImage');
            Route::put('/{user}/background-image', 'UsersController@setBackgroundImage')->name('admin.users.setBackgroundImage');

            Route::get('/{user}/image', 'UsersController@getProfileImage')->name('admin.users.profile-image');
            Route::get('/{user}/background-image', 'UsersController@getBackgroundImage')->name('admin.users.background-image');
        });
    });
});


// Route::get('/notify', 'Admin\Http\Controllers\UsersController@test');
