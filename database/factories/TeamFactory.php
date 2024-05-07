<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = Country::pluck('id')->toArray();
        $divisions = Division::pluck('id')->toArray();

        return [
            'name' => $this->faker->unique()->word(),
            'country_id' => $this->faker->randomElement($countries),
            'division_id' => $this->faker->randomElement($divisions),
        ];
    }
}
