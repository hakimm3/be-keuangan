<?php

namespace App\Http\Controllers;

use App\Models\BudgetGroup;
use Carbon\Carbon;
use App\Models\Income;
use App\Models\Spending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __invoke(Request $request)
    {
        $baseQuerySpending = Spending::query()->with('category')
            ->where('user_id', Auth::user()->id)
            // ->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
            ->when($request->year, function($query) use ($request){
                $query->whereYear('date', $request->year);
            })
            ->when(!$request->year, function($query){
                $query->whereYear('date', Carbon::now()->year);
            });
        
        $baseQueryIncome = Income::query()->with('category')
            ->where('user_id', Auth::user()->id)
            // ->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
            ->when($request->year, function($query) use ($request){
                $query->whereYear('date', $request->year);
            })
            ->when(!$request->year, function($query){
                $query->whereYear('date', Carbon::now()->year);
            });

        return response()->json([
            'success' => true,
            'data' => [
                    'expense_stream_by_month' => $this->ExpenseStreamByMonth($baseQuerySpending->clone(), $request),
                    'income_stream_by_month' => $this->IncomeStreamByMonth($baseQueryIncome->clone()),
                    'income_vs_expense_by_month' => $this->IncomeVsExpenseByMonth($baseQueryIncome->clone(), $baseQuerySpending->clone()),
                    'expense_by_wallet' => $this->expenseByWallet($baseQuerySpending->clone()),

                    'total_expense_this_month' => $baseQuerySpending->whereMonth('date', Carbon::now()->month)->sum('amount'),
                    'total_income_this_month' => $baseQueryIncome->whereMonth('date', Carbon::now()->month)->sum('amount'),
                    'total_money_in_all_wallet' => Auth::user()->wallets->sum('balance'),
                ]
            ]);
    }

    private function ExpenseStreamByMonth($baseQuerySpending, $request){
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

        // get budget
       $budgetsQuery = BudgetGroup::withSum('budgets', 'amount')->where('user_id', Auth::user()->id)
        ->when($request->year, function($query) use ($request){
            $query->whereYear('date', $request->year);
        })
        ->when(!$request->year, function($query){
            $query->whereYear('date', Carbon::now()->year);
        })
       ->where('type', 'monthly')->get();
       foreach($budgetsQuery as $budget){
            $month = Carbon::parse($budget->date)->format('F');
            $result[$month][] = [
                'category' => 'budget',
                'total' => $budget->budgets_sum_amount
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

        $orderedResult = collect($result)->sortBy(function ($value, $key) {
            return Carbon::parse($key)->month;
        })->toArray();

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