<?php

namespace App\Models;

use Core\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'created_at'
    ];
}
