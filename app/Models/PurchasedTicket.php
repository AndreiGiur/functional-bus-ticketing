<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasedTicket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ticket_type',
        'quantity',
        'total_price',
    ];

    /**
     * The default attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'quantity' => 1, // Default value to avoid missing value errors
    ];

    /**
     * Define the relationship with User.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
