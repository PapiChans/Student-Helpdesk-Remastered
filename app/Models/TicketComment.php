<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'ticket_comments';

    // Primary Key
    protected $primaryKey = 'comment_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'comment_id',
        'ticket_id',
        'user_id',
        'comment',
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
