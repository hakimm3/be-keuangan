<?php

namespace App\Http\Controllers\Spending;

use Carbon\Carbon;
use App\Models\Spending;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SpendingStoreRequest;

class SpendingController extends Controller
{
    public function index()
    {
        $spendings = Spending::with('category')->where('user_id', auth()->user()->id)->orderByDesc('date')->get();
        return response()->json([
            'success' => true,
            'data' => $spendings
        ]);
    }

    public function store(SpendingStoreRequest $request)
    {
        $spending = Spending::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => Carbon::parse($request->date)->format('Y-m-d')
        ]);
        return response()->json([
            'success' => true,
            'data' => $spending
        ]);
    }

    public function update(SpendingStoreRequest $request, $id)
    {
        $spending = Spending::find($id);
        $spending->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => Carbon::parse($request->date)->format('Y-m-d')
        ]);
        return response()->json([
            'success' => true,
            'data' => $spending
        ]);
    }

    public function destroy($id)
    {
        $spending = Spending::find($id);
        $spending->delete();
        return response()->json(['message' => 'Spending deleted']);
    }
}
