<?php

namespace App\Http\Controllers\Authorization\Invoke;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BulkDeleteUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        User::whereIn('id', $request->ids)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Users deleted successfully',
        ]);
    }
}
