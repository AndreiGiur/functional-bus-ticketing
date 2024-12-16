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
        Schema::create('balances', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('user_id') // Foreign key linking to the users table
            ->constrained()
                ->onDelete('cascade'); // Deletes balance entry when the user is deleted
            $table->decimal('balance', 15, 2)->default(0.00); // Balance field with precision
            $table->timestamps(); // Adds created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
