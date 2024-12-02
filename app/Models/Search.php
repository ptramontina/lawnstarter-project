<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [
        'search_text',
        'type',
        'request_start',
        'request_end',
        'duration',
    ];
}
