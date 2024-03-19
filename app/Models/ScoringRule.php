<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ScoringRule extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'points'];

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'player_statistics')->withPivot('game_id');
    }
}
