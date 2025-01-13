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
        Schema::create('fix_deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('account_no');
            $table->decimal('amount', 18);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->boolean('is_released')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fix_deposits');
    }
};
