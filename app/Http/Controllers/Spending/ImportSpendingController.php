<?php

namespace App\Http\Controllers\Spending;

use Illuminate\Http\Request;
use App\Imports\SpendingImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportSpendingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        Excel::import(new SpendingImport, $request->file('file'));

        return response()->json([
            'success' => true,
            'message' => 'Spendings imported'
        ]);
    }
}
