<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller as Controller;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Requests\StoreRoleRequest;


class RolesController extends Controller
{

    /**
     * Roles listing.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::all();

        return view('roles.index')->with(compact('roles'));
    }

    /**
     * Show the form to create a new role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Create a role.
     *
     * @param \App\Http\Requests\StoreRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(StoreRoleRequest $request)
    {

        // @todo allow the possibility to add permission(s) on 
        // role creation

        $role = Role::create([
            'name' => $request->name,
            //
        ]);

        if (! $role) {
            return new \Exception("Could not create role.");
        }

        return redirect()->route('admin.roles')->with([
            'message' =>  'Role created.',
            'status' => 'success',
        ]);
    }

    /**
     * Edit a role.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @return \Illuminate\View\View
     */
    public function edit(Role $role)
    {
        return view('roles.edit')->with(compact('role'));
    }

    /**
     * Update a role.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @param \App\Http\Requests\StoreRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Role $role, StoreRoleRequest $request)
    {
        $role->update($request->all());

        return redirect()->route('admin.roles')->with([
            'message' =>  'Role update.',
            'status' => 'success',
        ]);
    }


    /**
     * Delete a role.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Role $role)
    {
        $role->delete();

        return redirect()->back()->with([
            'message' =>  'Role deleted.',
            'status' => 'success',
        ]);
    }

    //
}
