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
        Schema::create('spendings', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->foreignId('user_id');
            $table->foreignUuid('category_id');
            $table->date('date');
            $table->bigInteger('amount');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('spendings');
    }
};
