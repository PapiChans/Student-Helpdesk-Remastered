<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    // Protected Table Name
    protected $table =  'evaluation';

    // Primary Key
    protected $primaryKey = 'evaluation_id';

    // No incrementing for UUID
    protected $keyType = 'string';

    // Disabled Auto-incrementing
    public $incrementing = false;

    // Fillables
    protected $fillable = [
        'evaluation_id',
        'user_id',
        'reference',
        'status',
        'QA',
        'QB',
        'QC',
        'QD',
        'QE',
        'QF',
        'QG',
        'QH',
        'remarks',
    ];

    // Set timestamps
    protected $dates = ['created_at', 'updated_at'];
}
