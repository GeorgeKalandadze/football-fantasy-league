<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoringRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scoringRules = [
            ['name' => 'Goal', 'points' => 4],
            ['name' => 'Goal from Outside Penalty Area', 'points' => 5],
            ['name' => "Goalkeeper's Goal", 'points' => 7],
            ['name' => 'Goal Assist', 'points' => 3],
            ['name' => 'Penalty Win', 'points' => 2],
            ['name' => 'Best Player of the Match', 'points' => 3],
            ['name' => 'Clean Sheet at Half Time', 'points' => 1],
            ['name' => 'Clean Sheet Throughout the Match', 'points' => 4],
            ['name' => 'Penalty Save', 'points' => 4],
            ['name' => '2 Goals Conceded', 'points' => -1],
            ['name' => 'Penalty Miss', 'points' => -1],
            ['name' => 'Penalty Save', 'points' => -2],
            ['name' => 'Yellow Card', 'points' => -1],
            ['name' => 'Red Card', 'points' => -3],
            ['name' => 'Own Goal', 'points' => -2],
        ];

        if (! DB::table('scoring_rules')->count()) {
            DB::table('scoring_rules')->insert($scoringRules);
        }
    }
}
