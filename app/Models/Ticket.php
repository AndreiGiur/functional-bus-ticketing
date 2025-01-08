<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'type', // Example column for ticket type
        'price',
        'quantity',
        'total_price',
        'purchase_date',
        'created_at',
        'updated_at',
    ];

    // Define the relationship with Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
