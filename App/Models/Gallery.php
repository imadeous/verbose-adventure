<?php

namespace App\Models;

use Core\Model;

class Gallery extends Model
{
    protected ?string $table = 'gallery';
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'created_at'
    ];
}
