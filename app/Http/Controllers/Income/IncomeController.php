<?php

namespace App\Http\Controllers\Income;

use App\Models\Income;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeRequest;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function index()
    {
        $data = Income::with('category')->where('user_id', auth()->id())->orderByDesc('date')->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function store(IncomeRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['date'] = Carbon::parse($request->date)->timezone('Asia/Jakarta')->format('Y-m-d');
        $income = Income::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $income
        ]);
    }

    public function update(IncomeRequest $request, $id)
    {
        $income = Income::find($id);
        $data = $request->validated();
        $data['date'] = Carbon::parse($request->date)->timezone('Asia/Jakarta')->format('Y-m-d');
        $income->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $income
        ]);
    }

    public function destroy($id)
    {
        $income = Income::find($id);
        $income->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Income deleted'
        ]);
    }
}
