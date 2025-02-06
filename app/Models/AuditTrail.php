<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AuditTrail extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'audit_trails';

    // Primary Key
    protected $primaryKey = 'audit_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'audit_id',
        'reference',
        'action',
        'description'
    ];

    // Set timestamps
    protected $dates = ['created_at', 'updated_at'];
}
