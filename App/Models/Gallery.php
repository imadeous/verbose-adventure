<?php

namespace App\Models;

use Core\Model;

class Gallery extends Model
{
    protected ?string $table = 'gallery'; // or whatever your table name is
    protected $fillable = [
        'title',
        'caption',
        'image_type',
        'related_id',
        'image_url',
        'created_at'
    ];
}
