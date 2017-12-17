<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller as Controller;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesController extends Controller
{

    /**
     * Roles listing.
     *
     * @return \Illuminate\Http\Request
     */
    public function index()
    {
        $roles = Role::all();

        return view('roles.index')->with(compact('roles'));
    }

    //

}

