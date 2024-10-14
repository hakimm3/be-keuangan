<?php

namespace App\Http\Controllers\MasterData\Invoke;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class BulkDeleteWalletController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Wallet::whereIn('id', $request->ids)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Incomes deleted'
        ]);
    }
}
