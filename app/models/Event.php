<?php

namespace App\Models;

use Core\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';

    // List of fillable columns for mass assignment
    protected $fillable = [
        'title',
        'introduction',
        'details',
        'tags',
        'start_date',
        'end_date',
        'venue',
        'logo',
        'banner',
        'created_at',
        'updated_at',
    ];

    // Optionally, add validation or helper methods here
}
