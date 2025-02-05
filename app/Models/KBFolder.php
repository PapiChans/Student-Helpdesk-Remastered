<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KBFolder extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'k_b_folders';

    // Primary Key
    protected $primaryKey = 'folder_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'folder_id',
        'folder_name'
    ];

    // Set timestamps
    protected $dates = ['created_at', 'updated_at'];

    // Defining Relationships
    public function KBTopic()
    {
        return $this->hasMany(KBTopic::class, 'folder_id', 'folder_id');
    }
}
