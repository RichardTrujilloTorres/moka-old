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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Admin')->group(function () {
    Route::middleware(['web', 'auth'])->group(function() {
        Route::prefix('/admin')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

            Route::get('/users/roles', 'RolesController@index')->name('admin.roles');

        });
    });
});

