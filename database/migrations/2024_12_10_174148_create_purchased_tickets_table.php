<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasedTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_tickets', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID for each record
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key reference to the users table
            $table->string('ticket_type'); // Type of the ticket (e.g., "1-day", "subscription")
            $table->integer('quantity'); // Quantity of tickets purchased
            $table->decimal('total_price', 8, 2); // Total price for the purchase
            $table->timestamps(); // Timestamps (created_at and updated_at)

            // Optionally add indexes for performance
            $table->index('user_id');
            $table->index('ticket_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchased_tickets');
    }
}
