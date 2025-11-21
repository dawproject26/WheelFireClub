<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Score extends Model
{
    use HasFactory;
    protected $fillable = ['points', 'player_id'];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}