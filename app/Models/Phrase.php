<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    protected $table = 'phrases';

    protected $fillable = [
        'movie',
        'phrase'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
