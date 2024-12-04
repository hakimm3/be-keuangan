<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequest;
use App\Models\Budget;
use App\Models\BudgetGroup;
use App\Models\SpendingCategories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->month && $request->year){
            $name = $request->month. ' '. $request->year;
            $date = Carbon::parse($name)->format('Y-m-d');

            $budgetGroup = BudgetGroup::firstOrCreate([
                'user_id' => Auth::user()->id,
                'name' => $name,
                'type' => 'monthly',
                'date' => $date
            ]);
            $budgets = Budget::where('budget_group_id', $budgetGroup->id)->get();
        }

        $spendingCategories = SpendingCategories::all();

        foreach($spendingCategories as $category){
            $category->budget = $budgets->where('spending_category_id', $category->id)->first() ?? [];
        }

        
        return response()->json([
            'success' => true,
            'data'  => $spendingCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BudgetRequest $request)
    {
        $name = $request->month. ' '. $request->year;
        $date = Carbon::parse($name)->format('Y-m-d');

        $budgetGroup = BudgetGroup::firstOrCreate([
            'type' => 'monthly',
            'date' => $date
        ]);

        $data = Budget::updateOrCreate(
            ['budget_group_id' => $budgetGroup->id, 'spending_category_id' => $request->spending_category_id],
            ['amount' => $request->amount]
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
