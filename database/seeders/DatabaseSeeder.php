<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            PositionSeeder::class,
            DivisionSeeder::class,
            ScoringRuleSeeder::class,
            RolesSeeder::class,
            TeamSeeder::class,
            FixtureSeeder::class,
        ]);
    }
}
