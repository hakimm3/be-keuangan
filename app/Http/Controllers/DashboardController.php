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
            ->where('user_id', auth()->id())
            ->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
        
        $baseQueryIncome = Income::query()->with('category')
            ->where('user_id', auth()->id())
            ->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);

        return response()->json([
            'success' => true,
            'data' => [
                    'expense_stream_by_month' => $this->ExpenseStreamByMonth($baseQuerySpending->clone()),
                    'income_stream_by_month' => $this->IncomeStreamByMonth($baseQueryIncome->clone()),
                    'income_vs_expense_by_month' => $this->IncomeVsExpenseByMonth($baseQueryIncome->clone(), $baseQuerySpending->clone()),
                    'expense_by_wallet' => $this->expenseByWallet($baseQuerySpending->clone()),

                    'total_expense_this_month' => $baseQuerySpending->whereMonth('date', Carbon::now()->month)->sum('amount'),
                    'total_income_this_month' => $baseQueryIncome->whereMonth('date', Carbon::now()->month)->sum('amount'),
                    'total_money_in_all_wallet' => auth()->user()->wallets->sum('balance'),
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

    private function IncomeVsExpenseByMonth($baseQueryIncome, $baseQuerySpending){
        $incomes = $baseQueryIncome
            ->selectRaw('sum(amount) as total, month(date) as month')
            ->groupBy('month')
            ->get();

        $spendings = $baseQuerySpending
            ->selectRaw('sum(amount) as total, month(date) as month')
            ->groupBy('month')
            ->get();

        $result = [];

        foreach ($incomes as $income) {
            $monthName = Carbon::create()->month($income->month)->format('F');
            if (!isset($result[$monthName])) {
                $result[$monthName] = [];
            }
            $result[$monthName]['income'] = $income->total;
        }

        foreach ($spendings as $spending) {
            $monthName = Carbon::create()->month($spending->month)->format('F');
            if (!isset($result[$monthName])) {
                $result[$monthName] = [];
            }
            $result[$monthName]['expense'] = $spending->total;
        }

        // return $result;
        $orderedResult = collect($result)->sortBy(function ($value, $key) {
            return Carbon::parse($key)->month;
        })->toArray();
        // dd($orderedResult);

        return $orderedResult;
    }

    private function expenseByWallet($baseQuerySpending){
        $spendings = $baseQuerySpending
            ->selectRaw('sum(amount) as total, user_wallet_id')
            ->groupBy('user_wallet_id')
            ->get();

        $result = [];

        foreach ($spendings as $spending) {
            $result[] = [
                'wallet' => $spending->wallet->name,
                'total' => $spending->total
            ];
        }

        return $result;
    }
}