<?php

/*
|--------------------------------------------------------------------------
| Pages
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});


Route::redirect('/home', '/admin/dashboard', 301);


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::namespace('Admin')->group(function () {
    Route::middleware([
        'web', 
        'auth', 
        // 'role:admin',
    ])->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

            Route::get('/users/roles', 'RolesController@index')->name('admin.roles');
            Route::post('/users/roles', 'RolesController@store')->name('admin.roles.store');
            Route::get('/users/roles/{role}/edit', 'RolesController@edit')->name('admin.roles.edit');
            Route::put('/users/roles/{role}', 'RolesController@update')->name('admin.roles.update');
            Route::get('/users/roles/create', 'RolesController@create')->name('admin.roles.create');
            Route::delete('/users/roles/{role}', 'RolesController@delete')->name('admin.roles.delete');
        });
    });
});


Auth::routes();
