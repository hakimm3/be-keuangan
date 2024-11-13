<?php

namespace App\Http\Controllers\UserWallet\Invoke;

use App\Http\Controllers\Controller;
use App\Models\Spending;
use App\Models\SpendingCategories;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'wallet_source_id' => 'required',
            'wallet_destionation_id' => 'required',
            'amount' => 'required',
            'admin_fee' => 'required',
            'date' => 'required'
        ]);

        DB::beginTransaction();
        $walletDestionation = UserWallet::find($request->wallet_destionation_id);

        $finalDestinationBallance = $walletDestionation->balance + $request->amount;
        $walletDestionation->update(['balance' => $finalDestinationBallance]);

        $walletSource = UserWallet::find($request->wallet_source_id);

        $totalFee = $request->amount + $request->admin_fee;
        $finallFee = $walletSource->balance - $totalFee;

        $walletSource->update(['balance' => $finallFee]);

        $spendingCategories = SpendingCategories::whereName('Admin Fee')->first();
        $spending = Spending::create([
            'user_id' => Auth::user()->id,
            'category_id' => $spendingCategories->id,
            'user_wallet_id' => $walletSource->id,
            'description' => 'Admin Fee from ' . $walletSource->wallet->name . ' to ' . $walletDestionation->wallet->name,
            'date' => Carbon::parse($request->date)->timezone('Asia/Jakarta')->format('Y-m-d'),
            'amount' => $request->admin_fee
        ]);

        UserWalletTransaction::create([
            'user_wallet_id' => $walletSource->id,
            'spending_id'   => $spending->id,
            'amount'   => $spending->amount,
            'type' => 'out',
            'description' => $spending->description,
            'date' => $spending->date
        ]);
        DB::commit();   

        return response()->json([
            'success' => true,
            'message' => 'Top Up wallet successfully'
        ]);
    }
}
