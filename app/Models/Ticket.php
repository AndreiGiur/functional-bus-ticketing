<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', // Example column for ticket type
        'price', // Example column for ticket price
    ];

    // Define the relationship with Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
