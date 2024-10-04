<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Income;
use App\Models\Spending;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __invoke(Request $request)
    {
        $baseQuerySpending = Spending::query()->with('category')
            // ->where('user_id', auth()->id())
            ->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
        
        $baseQueryIncome = Income::query()->with('category')
            // ->where('user_id', auth()->id())
            ->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);

        return response()->json([
            'success' => true,
            'data' => [
                    'expense_stream_by_month' => $this->ExpenseStreamByMonth($baseQuerySpending),
                    'income_stream_by_month' => $this->IncomeStreamByMonth($baseQueryIncome)
                ]
            ]);
    }

    private function ExpenseStreamByMonth($baseQuerySpending){
        $spendings = $baseQuerySpending
            ->selectRaw('sum(amount) as total, month(date) as month, category_id')
            ->groupBy('month', 'category_id')
            ->get();

        $result = [];

        foreach ($spendings as $spending) {
            $monthName = Carbon::create()->month($spending->month)->format('F');
            if (!isset($result[$monthName])) {
                $result[$monthName] = [];
            }
            $result[$monthName][] = [
                'category' => $spending->category->name,
                'total' => $spending->total
            ];
        }

        return $result;
    }

    private function IncomeStreamByMonth($baseQueryIncome){
        $incomes = $baseQueryIncome
            ->selectRaw('sum(amount) as total, month(date) as month, category_id')
            ->groupBy('month', 'category_id')
            ->get();

        $result = [];

        foreach ($incomes as $income) {
            $monthName = Carbon::create()->month($income->month)->format('F');
            if (!isset($result[$monthName])) {
                $result[$monthName] = [];
            }
            $result[$monthName][] = [
                'category' => $income->category->name,
                'total' => $income->total
            ];
        }

        return $result;
    }
}