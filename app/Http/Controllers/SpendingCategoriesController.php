<?php

namespace App\Http\Controllers;

use App\Models\SpendingCategories;
use Illuminate\Http\Request;

class SpendingCategoriesController extends Controller
{
    public function index(){
        $spendingCategories = SpendingCategories::all();
        return response()->json([
            'success' => true,
            'data' => $spendingCategories
        ]);
    }
}
