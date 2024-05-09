<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Fixture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FixtureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = Division::with('teams')->get();

        foreach ($divisions as $division) {
            $teams = $division->teams->pluck('id');
            $teamCount = count($teams);


            for ($week = 1; $week <= $teamCount - 1; $week++) {
                $currentWeekTeams = $teams->slice($week - 1)->merge($teams->take($week - 1)->reverse());

                for ($i = 0; $i < $teamCount / 2; $i++) {
                    $homeTeam = $currentWeekTeams[$i];
                    $awayTeam = $currentWeekTeams[$teamCount - 1 - $i];

                    Fixture::create([
                        'home_team_id' => $homeTeam,
                        'away_team_id' => $awayTeam,
                        'date' => Carbon::now()->startOfWeek()->addWeeks($week - 1),
                        'division_id' => $division->id,
                        'week' => $week,
                    ]);
                }
            }
        }
    }
}
