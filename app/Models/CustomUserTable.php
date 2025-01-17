<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash; // For Password Hashing
use Illuminate\Support\Str;

// Required for Authentication
use Illuminate\Contracts\Auth\Authenticatable;


class CustomUserTable extends Model implements Authenticatable
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'custom_user_tables';

    // Primary Key
    protected $primaryKey = 'user_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'user_id',
        'email',
        'password',
        'is_admin',
        'lockout_expiration',
        'login_attempts',
    ];

    // Set timestamps
    protected $dates = ['lockout_expiration', 'created_at', 'updated_at'];

    // Defining Relationships
    public function userprofile()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'user_id');
    }

    public function adminprofile()
    {
        return $this->hasOne(AdminProfile::class, 'user_id', 'user_id');
    }

    // Implement Authenticatable methods
    public function getAuthIdentifierName()
    {
        return 'user_id';  // Return the name of the primary key column
    }

    public function getAuthIdentifier()
    {
        return $this->user_id;  // Return the value of the primary key
    }

    public function getAuthPassword()
    {
        return $this->password;  // Return the hashed password
    }

    public function getRememberToken()
    {
        return $this->remember_token;  // Return the remember token if available
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;  // Set the remember token
    }

    public function getRememberTokenName()
    {
        return 'remember_token';  // Return the remember token column name
    }
}
