<?php

namespace App\Console\Commands;

use App\Events\PlayerStatisticsRecorded;
use App\Models\Fixture;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateWeeklyGames extends Command
{
    protected $signature = 'games:generate';

    protected $description = 'Generate games for the upcoming week based on fixtures';

    public function handle()
    {
        $fixtures = Fixture::where('date', '>=', Carbon::now()->startOfWeek())
            ->where('date', '<=', Carbon::now()->endOfWeek())
            ->get();

        foreach ($fixtures as $fixture) {
            $homeTeam = $fixture->homeTeam;
            $awayTeam = $fixture->awayTeam;

            $homeTeamGoals = rand(0, 5);
            $awayTeamGoals = rand(0, 5);

            $game = Game::create([
                'fixture_id' => $fixture->id,
                'home_team_goals' => $homeTeamGoals,
                'away_team_goals' => $awayTeamGoals,
            ]);

            foreach ($homeTeam->players as $player) {
                event(new PlayerStatisticsRecorded($player, $game, $homeTeamGoals));
            }

            foreach ($awayTeam->players as $player) {
                event(new PlayerStatisticsRecorded($player, $game, $awayTeamGoals));
            }
        }

        $this->info('Games for the upcoming week have been generated successfully.');
    }
}
