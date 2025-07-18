<?php

namespace App\Models;

use Core\Model;

class Gallery extends Model
{
    protected $table = 'gallery';
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'created_at'
    ];
}
