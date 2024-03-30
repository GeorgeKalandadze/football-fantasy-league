<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            ['name' => 'Amateur'],
            ['name' => 'Pro'],
            ['name' => 'Elite'],
        ];

        if (! DB::table('divisions')->count()) {
            DB::table('divisions')->insert($divisions);
        }
    }
}
