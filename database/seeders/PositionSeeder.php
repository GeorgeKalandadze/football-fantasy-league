<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => 'Goalkeeper', 'abbreviation' => 'GK'],
            ['name' => 'Defender', 'abbreviation' => 'DEF'],
            ['name' => 'Midfielder', 'abbreviation' => 'MID'],
            ['name' => 'Forward', 'abbreviation' => 'FWD'],
        ];

        if (! DB::table('positions')->count()) {
            DB::table('positions')->insert($positions);
        }
    }
}
