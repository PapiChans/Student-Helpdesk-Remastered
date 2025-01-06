<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash; // For Password Hashing
use Illuminate\Support\Str;

class CustomUserTable extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'custom_user_tables';

    // Primary Key
    protected $primaryKey = 'user_Id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Fillables
    protected $fillable = [
        'email',
        'password',
        'is_admin',
        'lockout_expiration',
        'login_attempts',
    ];

    // Set timestamps
    protected $dates = ['lockout_expiration', 'created_at', 'updated_at'];


    
}
