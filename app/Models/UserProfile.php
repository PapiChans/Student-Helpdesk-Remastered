<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserProfile extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'user_profiles';

    // Primary Key
    protected $primaryKey = 'profile_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'profile_id',
        'user_id',
        'last_name',
        'first_name',
        'middle_name',
        'gender',
    ];

    // Set timestamps
    protected $dates = ['created_at', 'updated_at'];

    // Defining Relationships
    public function user()
    {
        return $this->belongsTo(CustomUserTable::class, 'user_id', 'user_id');
    }
}
