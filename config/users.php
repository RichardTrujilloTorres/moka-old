<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Users Administration Package Configuration 
    |--------------------------------------------------------------------------
    |
    | //
    |
    */

    'url_prefix' => env('ADMIN_PANEL_URL_PREFIX', '/admin/users'),

    'routes' => [
        'namespace' => 'Admin\Http\Controllers',
        'prefix' => '/admin/users',
        'middleware' => '',
        'as' => 'admin.users',
    ],
];
