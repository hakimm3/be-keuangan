<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->as('auth.')->group(function(){
    // Route::post('login', \App\Http\Controllers\auth\LoginController::class)->name('login');
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('me', [\App\Http\Controllers\AuthController::class, 'me'])->name('me');
});

Route::middleware('auth:api')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('dashboard', \App\Http\Controllers\DashboardController::class);

    Route::resource('spendings', \App\Http\Controllers\Spending\SpendingController::class);
    Route::post('spendings/bulk-delete', \App\Http\Controllers\Spending\BulkDeleteSpendingController::class);
    Route::post('spendings/import', \App\Http\Controllers\Spending\ImportSpendingController::class);

    Route::resource('incomes', \App\Http\Controllers\Income\IncomeController::class);
    Route::post('incomes/bulk-delete', \App\Http\Controllers\Income\BulkDeleteIncomeController::class);
    Route::post('incomes/import', \App\Http\Controllers\Income\ImportIncomeController::class);

    Route::resource('user-wallets', \App\Http\Controllers\UserWallet\UserWalletController::class);

    Route::prefix('master-data')->as('master-data.')->group(function(){
        Route::resource('income-categories', \App\Http\Controllers\MasterData\IncomeCategoriesController::class);
        Route::resource('spending-categories', \App\Http\Controllers\MasterData\SpendingCategoriesController::class);
        Route::resource('wallets', \App\Http\Controllers\MasterData\WalletController::class);
    });

    Route::prefix('authorization')->as('authorization.')->group(function(){
        Route::resource('users', \App\Http\Controllers\Authorization\UserController::class);
    });
});
