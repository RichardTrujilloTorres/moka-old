<?php

/*
|--------------------------------------------------------------------------
| Pages
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', 'HomeController@index')->name('home');



/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::namespace('Admin')->group(function () {
    Route::middleware(['web', 'auth'])->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

            Route::get('/users/roles', 'RolesController@index')->name('admin.roles');
        });
    });
});


Auth::routes();
