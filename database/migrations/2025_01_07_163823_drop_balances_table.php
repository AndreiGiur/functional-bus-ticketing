<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBalancesTable extends Migration
{
    /**
     * Run the migrations to drop the balances table.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('balances');
    }

    /**
     * Reverse the migrations to recreate the balances table (if needed).
     *
     * @return void
     */
    public function down()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->decimal('balance', 8, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
