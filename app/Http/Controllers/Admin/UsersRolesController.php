<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;

class UsersRolesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function associate()
    {
        return view('users-roles.associate');
    }
}
