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
        Schema::create('monthly_deposits', function (Blueprint $table) {
            $table->id(); // This will create an auto-incrementing ID column
            $table->unsignedBigInteger('user_id'); // Foreign key for the user
            $table->decimal('amount', 10, 2); // Amount with two decimal places
            $table->string('month', 2); // Month as a string (01-12)
            $table->year('year'); // Year as a 4-digit year
            $table->date('deposited_on'); // Deposited on date
            $table->timestamps(); // Created at and updated at timestamps

        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_deposits');
    }
};
