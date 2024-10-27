<?php

namespace App\Http\Controllers\Authorization\Invoke;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class BulkDeleteRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Role::whereIn('id', $request->ids)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Roles deleted successfully',
        ]);
    }
}
