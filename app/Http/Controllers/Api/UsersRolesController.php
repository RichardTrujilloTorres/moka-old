<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UsersRolesAssociationRequest;
use App\User;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class UsersRolesController extends Controller
{
    /**
     * @param array $users
     * @return array
     * @throws \Exception
     */
    protected function getUsers(array $users)
    {
        $resource = [];
        foreach ($users as $user) {
            // TODO add repository or similar
            $single = User::find($user['id']);
            if (empty($single)) {
                throw new \Exception("Could not find user with ID {$user['id']}");
            }

            $resource[] = $single;
        }

        return $resource;
    }

    /**
     * @param array $roles
     * @return array
     * @throws \Exception
     */
    protected function getRoles(array $roles)
    {
        $resource = [];
        foreach ($roles as $role) {
            // TODO add repository or similar
            $single = Role::find($role['id']);
            if (empty($single)) {
                throw new \Exception("Could not find role with ID {$role['id']}");
            }

            $resource[] = $single;
        }

        return $resource;
    }

    /**
     * User(s)-to-Role(s) association.
     *
     * @param UsersRolesAssociationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function associate(UsersRolesAssociationRequest $request)
    {
        try {
            $users = $this->getUsers($request->users);
            $roles = $this->getRoles($request->roles);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
            ], 404);
        }

        foreach ($users as $user) {
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    continue;
                }

                $user->assignRole($role);
            }
        }

        return response()->json([
            'data' => [
                'users' => $users,
                'roles' => $roles,
            ],
            'message' => 'Roles assigned to users correctly.',
        ], 201);
    }
}
