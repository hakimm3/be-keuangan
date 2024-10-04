<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class BulkDeleteIncomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Income::whereIn('id', $request->ids)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Incomes deleted'
        ]);
    }
}
