<?php

namespace App\Http\Controllers\MasterData\Invoke;

use App\Http\Controllers\Controller;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;

class BulkDeleteIncomeCategoriesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        IncomeCategory::whereIn('id', $request->ids)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Incomes deleted'
        ]);
    }
}
