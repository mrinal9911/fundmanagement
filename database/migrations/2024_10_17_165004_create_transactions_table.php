<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // This will create an auto-incrementing ID column
            $table->date('date'); // Transaction date
            $table->enum('type', ['credit', 'debit']); // Transaction type (credit or debit)
            $table->decimal('balance', 10, 2); // Balance after the transaction
            $table->string('description')->nullable(); // Description of the transaction
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
