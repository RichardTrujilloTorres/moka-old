<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Controllers\Controller as Controller;
use Spatie\Permission\Models\Permission;


class PermissionsController extends Controller
{

    /**
     * Permission listing.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('permissions.index')->with(compact('permissions'));
    }

    /**
     * Show the form to create a new permission.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Creates a permission.
     *
     * @param \App\Http\Requests\StorePermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create([
            'name' => $request->name,
        ]);

        if (! $permission) {
            throw new \Exception("Could not create permission.");
        }

        return redirect()->route('admin.users.permissions.index')->with([
            'message' =>  'Permission created.',
            'status' => 'success',
        ]);
    }

    /**
     * Edits a permission.
     *
     * @param \Spatie\Permission\Models\Permission $permission
     * @return \Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit')->with(compact('permission'));
    }

    public function show(Permission $permission)
    {
        return view('permissions.edit')->with(compact('permission'));
    }

    /**
     * Updates a permission.
     *
     * @param \Spatie\Permission\Models\Permission $permission
     * @param \App\Http\Requests\StorePermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Permission $permission, StorePermissionRequest $request)
    {
        $permission->update($request->all());

        return redirect()->route('admin.users.permissions.index')->with([
            'message' =>  'Permission update.',
            'status' => 'success',
        ]);
    }

    /**
     * Deletes a permission.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->back()->with([
            'message' =>  'Permision deleted.',
            'status' => 'success',
        ]);
    }
}
