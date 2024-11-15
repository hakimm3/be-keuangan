<?php

namespace App\Http\Controllers\Income;

use Carbon\Carbon;
use App\Models\Income;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeRequest;
use App\Models\UserWalletTransaction;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        $data = Income::with('category', 'userWallet.wallet', 'wallet')->where('user_id', Auth::user()->id,)->orderByDesc('date')->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function store(IncomeRequest $request)
    {
        DB::beginTransaction();
        $income = Income::create([
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'user_wallet_id' => $request->user_wallet_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => Carbon::parse($request->date)->timezone('Asia/Jakarta')->format('Y-m-d')
        ]);

        $userWallet = UserWallet::find($income->user_wallet_id);
        $userWallet->update([
            'balance' => $userWallet->balance + $income->amount
        ]);

        UserWalletTransaction::create([
            'user_wallet_id' => $income->user_wallet_id,
            'income_id' => $income->id,
            'amount' => $income->amount,
            'type' => 'in',
            'description' => $income->description,
            'date' => $income->date
        ]);
        DB::commit();

        return response()->json([
            'status' => 'success',
            'data' => $income
        ]);
    }

    public function update(IncomeRequest $request, $id)
    {
        DB::beginTransaction();
        $income = Income::find($id);

        // if update wallet
        if ($income->user_wallet_id != $request->user_wallet_id) {
            $oldUserWallet = UserWallet::find($income->user_wallet_id);
            $oldUserWallet->update([
                'balance' => UserWallet::find($income->user_wallet_id)->balance - $request->amount
            ]);

            $newUserWallet = UserWallet::find($request->user_wallet_id);
            $newUserWallet->update([
                'balance' => UserWallet::find($request->user_wallet_id)->balance + $request->amount
            ]);
        }

        if($request->amount != $income->amount) {
            $userWallet = UserWallet::find($income->user_wallet_id);
            $userWallet->update([
                'balance' => $userWallet->balance - $income->amount + $request->amount
            ]);
        }

        UserWalletTransaction::updateOrCreate(['income_id' => $income->id], [
            'user_wallet_id' => $request->user_wallet_id,
            'amount' => $request->amount,
            'type' => 'in',
            'description' => $request->description,
            'date' => Carbon::parse($request->date)->timezone('Asia/Jakarta')->format('Y-m-d')
        ]);

        $income->update([
            'category_id' => $request->category_id,
            'user_wallet_id' => $request->user_wallet_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => Carbon::parse($request->date)->timezone('Asia/Jakarta')->format('Y-m-d')
        ]);
        DB::commit();

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
