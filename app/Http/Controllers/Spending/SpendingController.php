<?php

namespace App\Http\Controllers\Spending;

use Carbon\Carbon;
use App\Models\Spending;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserWalletTransaction;
use App\Http\Requests\SpendingStoreRequest;
use Illuminate\Support\Facades\DB;

class SpendingController extends Controller
{
    public function index()
    {
        $spendings = Spending::with('category', 'wallet', 'userWallet.wallet')->where('user_id', auth()->user()->id)->orderByDesc('date')->get();
        return response()->json([
            'success' => true,
            'data' => $spendings
        ]);
    }

    public function store(SpendingStoreRequest $request)
    {   
        DB::beginTransaction();
        $spending = Spending::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'user_wallet_id' => $request->user_wallet_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => Carbon::parse($request->date)->timezone('Asia/Jakarta')->format('Y-m-d')
        ]);

        $userWallet = UserWallet::find($spending->user_wallet_id);
        $userWallet->update([
          'balance' => $userWallet->balance - $spending->amount
        ]);

          UserWalletTransaction::create([
              'user_wallet_id' => $spending->user_wallet_id,
              'spending_id' => $spending->id,
              'amount' => $spending->amount,
              'type' => 'out',
              'description' => $spending->description,
              'date' => $spending->date
          ]);
        DB::commit();

        return response()->json([
            'success' => true,
            'data' => $spending
        ]);
    }

    public function update(SpendingStoreRequest $request, $id)
    {
        DB::beginTransaction();
        $spending = Spending::find($id);

        // if update wallet
        if ($request->user_wallet_id != $spending->user_wallet_id) {
            $oldWallet = UserWallet::find($spending->user_wallet_id)->update([
                'balance' => UserWallet::find($spending->user_wallet_id)->balance + $request->amount
            ]);

            $newWallet = UserWallet::find($request->user_wallet_id)->update([
                'balance' => UserWallet::find($request->user_wallet_id)->balance - $request->amount
            ]);
        }

        if($request->amount != $spending->amount) {
            $walletBalance = UserWallet::find($spending->user_wallet_id)->balance;

            $oldAmount = $spending->amount;
            $newAmount = $request->amount;

            $newBalance = $walletBalance + $oldAmount - $newAmount;
            
            UserWallet::find($spending->user_wallet_id)->update([
                'balance' => $newBalance
            ]);
        }

        // $userWalletTransaction = UserWalletTransaction::where('spending_id', $spending->id)->first();
        UserWalletTransaction::updateOrCreate(['spending_id' => $id],[
            'user_wallet_id' => $request->user_wallet_id,
            'amount' => $request->amount,
            'type' => 'out',
            'description' => $request->description,
            'date' => Carbon::parse($request->date)->timezone('Asia/Jakarta')->format('Y-m-d')
        ]);

        $spending->update([
            'category_id' => $request->category_id,
            'user_wallet_id' => $request->user_wallet_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => Carbon::parse($request->date)->timezone('Asia/Jakarta')->format('Y-m-d')
        ]);
        DB::commit();


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
