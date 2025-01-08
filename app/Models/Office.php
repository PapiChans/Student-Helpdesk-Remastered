<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Office extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'offices';

    // Primary Key
    protected $primaryKey = 'office_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'office_id',
        'office_name',
        'added_by'
    ];

    // Defining Relationships
    public function adminoffice()
    {
        return $this->hasMany(AdminProfile::class, 'office_id', 'office_id');
    }
}
