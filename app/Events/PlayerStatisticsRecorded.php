<?php

namespace App\Events;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerStatisticsRecorded
{
    use Dispatchable, SerializesModels;

    public $player;

    public $game;

    public $goals;

    public function __construct(Player $player, Game $game, $goals)
    {
        $this->player = $player;
        $this->game = $game;
        $this->goals = $goals;
    }
}
