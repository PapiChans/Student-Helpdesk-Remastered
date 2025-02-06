<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TicketRating extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'ticket_ratings';

    // Primary Key
    protected $primaryKey = 'rating_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'rating_id',
        'ticket_id',
        'user_id',
        'rating',
        'remarks',
    ];

    // Set timestamps
    protected $dates = ['created_at', 'updated_at'];

    // Defining Relationships
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    } 
    
    public function user()
    {
        return $this->belongsTo(CustomUserTable::class, 'user_id', 'user_id');
    }
}
