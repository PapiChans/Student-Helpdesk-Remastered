<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KBTopic extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'k_b_topics';

    // Primary Key
    protected $primaryKey = 'topic_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'topic_id',
        'folder_id',
        'title',
        'content',
        'likes',
        'dislikes',
        'status'
    ];

    // Set timestamps
    protected $dates = ['created_at', 'updated_at'];

    // Defining Relationships
    public function KBTopic()
    {
        return $this->belongsTo(KBFolder::class, 'folder_id', 'folder_id');
    }
}
