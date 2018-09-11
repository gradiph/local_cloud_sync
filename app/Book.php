<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name',
        'author',
    ];

    protected $casts = [
        'name' => 'string',
        'author' => 'string',
    ];
}
