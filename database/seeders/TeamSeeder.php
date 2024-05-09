<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $divisions = Division::all();

        foreach ($divisions as $division) {
            for ($i = 0; $i < 10; $i++) {
                $team = Team::factory()->create(['division_id' => $division->id]);
                Player::factory()->count(23)->create([
                    'team_id' => $team->id,
                ]);
            }
        }
    }
}
