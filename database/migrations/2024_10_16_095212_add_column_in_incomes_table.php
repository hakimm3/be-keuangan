<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->foreignId('user_wallet_id')->nullable()->after('category_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropForeign(['user_wallet_id']);
            $table->dropColumn('user_wallet_id');
        });
    }
};
