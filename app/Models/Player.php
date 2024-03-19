<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['firstname', 'lastname', 'age', 'market_price', 'country_id', 'position_id'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function fantasyTeams(): BelongsToMany
    {
        return $this->belongsToMany(FantasyTeam::class, 'fantasy_team_players', 'player_id', 'fantasy_team_id');
    }

    public function scoringRules(): BelongsToMany
    {
        return $this->belongsToMany(ScoringRule::class, 'player_statistics')->withPivot('game_id');
    }
}
