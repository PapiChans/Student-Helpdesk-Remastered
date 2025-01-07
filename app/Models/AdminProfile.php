<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdminProfile extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'admin_profiles';

    // Primary Key
    protected $primaryKey = 'profile_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'office_id',
        'is_master_admin',
        'is_technician'
    ];

    // Set timestamps
    protected $dates = ['created_at', 'updated_at'];

    // Defining Relationships
    public function user()
    {
        return $this->belongsTo(CustomUserTable::class, 'user_id', 'user_id');
    }  

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'office_id');
    }  

}
