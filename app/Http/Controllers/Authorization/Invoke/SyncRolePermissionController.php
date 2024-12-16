<?php

namespace App\Http\Controllers\Authorization\Invoke;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SyncRolePermissionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $permissions = $request->permissions;
        $role = Role::find($request->role_id);

        $role->syncPermissions($permissions);

        return response()->json([
            'status' => 'success',
            'message' => 'Role permission synced successfully',
            'data' => $role,
            'permissions' => Auth::guard('api')->user()->getAllPermissions()->pluck('name')
        ]);

    }
}
