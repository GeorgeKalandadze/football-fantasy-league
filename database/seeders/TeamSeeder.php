<?php

namespace Database\Seeders;

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
        $team = Team::factory()->create();

        Player::factory()->count(23)->create([
            'team_id' => $team->id,
        ]);
    }
}
