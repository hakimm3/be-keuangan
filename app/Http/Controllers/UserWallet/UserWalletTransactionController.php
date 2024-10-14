<?php

namespace App\Http\Controllers\UserWallet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserWalletTransaction;

class UserWalletTransactionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = UserWalletTransaction::with('userWallet', 'userWallet.wallet')->whereHas('userWallet', function ($query) {
            $query->where('user_id', auth()->id());
        })->orderByDesc('created_at')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}