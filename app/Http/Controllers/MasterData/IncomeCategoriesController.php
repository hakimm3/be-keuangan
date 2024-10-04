<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;

class IncomeCategoriesController extends Controller
{
    public function index()
    {
        $incomeCategories = IncomeCategory::latest()->get();
        return response()->json([
            'success' => true,
            'data' => $incomeCategories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        $incomeCategory = IncomeCategory::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'data' => $incomeCategory
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        $incomeCategory = IncomeCategory::findOrFail($id);
        $incomeCategory->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'data' => $incomeCategory
        ]);
    }

    public function destroy($id)
    {
        $incomeCategory = IncomeCategory::findOrFail($id);
        $incomeCategory->delete();
        return response()->json([
            'success' => true,
            'data' => $incomeCategory
        ]);
    }
}
