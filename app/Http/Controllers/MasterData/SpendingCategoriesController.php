<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Models\SpendingCategories;
use App\Http\Controllers\Controller;

class SpendingCategoriesController extends Controller
{
    public function index(){
        $spendingCategories = SpendingCategories::all();
        return response()->json([
            'success' => true,
            'data' => $spendingCategories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        $spendingCategory = SpendingCategories::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'data' => $spendingCategory
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        $spendingCategory = SpendingCategories::findOrFail($id);
        $spendingCategory->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'data' => $spendingCategory
        ]);
    }

    public function destroy($id)
    {
        $spendingCategory = SpendingCategories::findOrFail($id);
        $spendingCategory->delete();

        return response()->json([
            'success' => true,
            'data' => $spendingCategory
        ]);
    }
}
