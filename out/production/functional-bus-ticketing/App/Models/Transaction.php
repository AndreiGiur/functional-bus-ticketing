<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',  // Assuming this is the foreign key for the Ticket
        'amount',
        'type',
        'status',
    ];

    // Define the relationship with Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
