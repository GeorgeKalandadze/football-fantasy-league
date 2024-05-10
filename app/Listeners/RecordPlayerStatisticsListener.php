<?php

namespace App\Listeners;

use App\Events\PlayerStatisticsRecorded;
use App\Models\PlayerStatistic;
use App\Models\ScoringRule;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordPlayerStatisticsListener implements ShouldQueue
{
    public function handle(PlayerStatisticsRecorded $event)
    {
        for ($i = 0; $i < $event->goals; $i++) {
            $scoringRule = ScoringRule::inRandomOrder()->first();

            PlayerStatistic::create([
                'player_id' => $event->player->id,
                'game_id' => $event->game->id,
                'scoring_rule_id' => $scoringRule->id,
            ]);
        }
    }
}
