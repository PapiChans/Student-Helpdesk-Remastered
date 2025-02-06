<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'tickets';

    // Primary Key
    protected $primaryKey = 'ticket_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'ticket_id',
        'user_id',
        'ticket_number',
        'affiliation',
        'office_id',
        'priority',
        'status',
        'type',
        'resolved_date',
        'service',
    ];

    // Set timestamps
    protected $dates = ['resolved_date','created_at', 'updated_at'];

    // Defining Relationships
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'office_id');
    }

    public function user()
    {
        return $this->belongsTo(CustomUserTable::class, 'user_id', 'user_id');
    }

    public function ticketcomment()
    {
        return $this->hasMany(TicketComment::class, 'ticket_id', 'ticket_id');
    }

    public function ticketratings()
    {
        return $this->hasOne(TicketRating::class, 'ticket_id', 'ticket_id');
    }
}
