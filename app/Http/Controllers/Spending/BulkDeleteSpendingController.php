<?php

namespace App\Http\Controllers\Spending;

use App\Http\Controllers\Controller;
use App\Models\Spending;
use Illuminate\Http\Request;

class BulkDeleteSpendingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Spending::whereIn('id', $request->ids)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Spendings deleted'
        ]);
    }
}
