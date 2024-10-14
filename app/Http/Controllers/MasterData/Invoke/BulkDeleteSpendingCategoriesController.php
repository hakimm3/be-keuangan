<?php

namespace App\Http\Controllers\MasterData\Invoke;

use App\Http\Controllers\Controller;
use App\Models\SpendingCategories;
use Illuminate\Http\Request;

class BulkDeleteSpendingCategoriesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        SpendingCategories::whereIn('id', $request->ids)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Incomes deleted'
        ]);
    }
}
