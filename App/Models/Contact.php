<?php

namespace App\Models;

use Core\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $fillable = [
        'name',
        'email',
        'message',
        'created_at',
        'opened_at'
    ];
}
