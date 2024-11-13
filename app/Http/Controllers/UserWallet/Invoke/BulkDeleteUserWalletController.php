<?php

namespace App\Http\Controllers\UserWallet\Invoke;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use Illuminate\Http\Request;

class BulkDeleteUserWalletController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        UserWallet::whereIn('id', $request->ids)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Spendings deleted'
        ]);
    }
}
