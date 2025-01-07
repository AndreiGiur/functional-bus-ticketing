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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // User who purchased the ticket
            $table->string('type');
            $table->decimal('price', 8, 2)->default(0.00); // Price of the ticket with a default value
            $table->integer('quantity')->default(1); // Number of tickets purchased with a default of 1
            $table->decimal('total_price', 8, 2)->default(0.00); // Total price for the purchase with a default value
            $table->dateTime('purchase_date')->nullable(); // Allow null for purchase date if not set
            $table->timestamps(); // Created at / Updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
