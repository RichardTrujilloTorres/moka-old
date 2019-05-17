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
| API
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'api',
    'as' => 'api.',
    'middleware' => ['auth',],
    'namespace' => 'Api',
], function () {
    Route::resource('notifications', 'NotificationsController');
    Route::get('search/users', 'SearchController@users');
    Route::get('search/roles', 'SearchController@roles');
});


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth',],
    'namespace' => 'Admin',
    // 'middleware' => ['auth', 'role:admin'],
], function () {

    // Dashboard
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    /**
     * Users
     */
    Route::group([
        'prefix' => 'users',
        'as'    => 'users.',
    ], function () {
        Route::resource('roles', 'RolesController');
        Route::resource('permissions', 'PermissionsController');
        Route::resource('notifications', 'NotificationsController');
        Route::put('notifications/mark-as-read/{id}', 'NotificationsController@markAsRead')->name('notifications.mark-as-read');
    });

});

/*
Route::namespace('Admin')->group(function () {
    Route::middleware([
        // 'web',
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
*/


Auth::routes();
