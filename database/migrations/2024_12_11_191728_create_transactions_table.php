<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Associate with a user
            $table->decimal('amount', 8, 2);  // Total amount for the transaction
            $table->string('type');  // Type of transaction (e.g., 'purchase', 'subscription')
            $table->string('status');  // Status of the transaction (e.g., 'completed', 'pending')
            $table->timestamps();  // Created at & updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
