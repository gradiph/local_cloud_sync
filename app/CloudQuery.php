<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudQuery extends Model
{
    public $timestamps = FALSE;

    protected $fillable = [
        'created_at',
        'query',
        'executed_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'query' => 'string',
        'executed_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'executed_at',
    ];
}
