<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->as('auth.')->group(function(){
    // Route::post('login', \App\Http\Controllers\auth\LoginController::class)->name('login');
    Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
    Route::post('register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('register');
    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
    Route::get('me', [\App\Http\Controllers\Auth\AuthController::class, 'me'])->name('me');
});

Route::middleware('auth:api')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('dashboard', \App\Http\Controllers\DashboardController::class);

    Route::resource('spendings', \App\Http\Controllers\Spending\SpendingController::class)->only('index', 'store', 'update', 'destroy');
    Route::post('spendings/bulk-delete', \App\Http\Controllers\Spending\BulkDeleteSpendingController::class);
    Route::post('spendings/import', \App\Http\Controllers\Spending\ImportSpendingController::class);

    Route::resource('incomes', \App\Http\Controllers\Income\IncomeController::class)->only('index', 'store', 'update', 'destroy');
    Route::post('incomes/bulk-delete', \App\Http\Controllers\Income\BulkDeleteIncomeController::class);
    Route::post('incomes/import', \App\Http\Controllers\Income\ImportIncomeController::class);

    Route::resource('my-wallets', \App\Http\Controllers\UserWallet\UserWalletController::class)->only('index', 'store', 'update', 'destroy');
    Route::post('my-wallets/bulk-delete', \App\Http\Controllers\UserWallet\Invoke\BulkDeleteUserWalletController::class);
    Route::post('my-wallets/top-up', \App\Http\Controllers\UserWallet\Invoke\TopUpController::class);
    Route::get('my-wallets/transactions', \App\Http\Controllers\UserWallet\Invoke\UserWalletTransactionController::class);

    Route::resource('budgets', \App\Http\Controllers\Budget\BudgetController::class)->only('index', 'store');

    Route::prefix('master-data')->as('master-data.')->group(function(){
        Route::resource('income-categories', \App\Http\Controllers\MasterData\IncomeCategoriesController::class)->only('index', 'store', 'update', 'destroy');
        Route::post('income-categories/bulk-delete', \App\Http\Controllers\MasterData\Invoke\BulkDeleteIncomeCategoriesController::class);
        
        Route::resource('spending-categories', \App\Http\Controllers\MasterData\SpendingCategoriesController::class);
        Route::post('spending-categories/bulk-delete', \App\Http\Controllers\MasterData\Invoke\BulkDeleteSpendingCategoriesController::class);
        
        Route::resource('wallets', \App\Http\Controllers\MasterData\WalletController::class)->only('index', 'store', 'update', 'destroy');
        Route::post('wallets/bulk-delete', \App\Http\Controllers\MasterData\Invoke\BulkDeleteWalletController::class);
    });

    Route::prefix('authorization')->as('authorization.')->group(function(){
        Route::resource('users', \App\Http\Controllers\Authorization\UserController::class)->only('index', 'store', 'update', 'destroy');
        Route::post('users/bulk-delete', \App\Http\Controllers\Authorization\Invoke\BulkDeleteUserController::class);

        Route::resource('roles', \App\Http\Controllers\Authorization\RoleController::class)->only('index', 'store', 'update', 'show', 'destroy');
        Route::post('roles/bulk-delete', \App\Http\Controllers\Authorization\Invoke\BulkDeleteRoleController::class);
        Route::post('roles/sync-permissions', \App\Http\Controllers\Authorization\Invoke\SyncRolePermissionController::class);

        Route::resource('permissions', \App\Http\Controllers\Authorization\PermissionController::class)->only('index', 'store', 'update', 'destroy');
    });
});
