<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who purchased the ticket
            $table->string('type');
            $table->decimal('price', 8, 2); // Price of the ticket
            $table->integer('quantity'); // Number of tickets purchased
            $table->decimal('total_price', 8, 2); // Total price for the purchase
            $table->dateTime('purchase_date'); // Date and time when the ticket was purchased
            $table->timestamps(); // Created at / Updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
