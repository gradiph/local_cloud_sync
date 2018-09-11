<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalQuery extends Model
{
    public $timestamps = FALSE;

    protected $fillable = [
        'created_at',
        'query',
        'uploaded_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'query' => 'string',
        'uploaded_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'uploaded_at',
    ];
}
