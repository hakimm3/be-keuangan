<?php

namespace App\Http\Controllers\Income;

use Illuminate\Http\Request;
use App\Imports\IncomeImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportIncomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        Excel::import(new IncomeImport, $request->file('file'));
       
        return response()->json([
            'success' => true,
            'message' => 'Incomes imported'
        ]);
    }
}
