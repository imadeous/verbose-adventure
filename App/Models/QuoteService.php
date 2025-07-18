<?php

namespace App\Models;

use Core\Model;

class QuoteService extends Model
{
    protected $table = 'quote_services';
    protected $fillable = [
        'quote_id',
        'service'
    ];
}
