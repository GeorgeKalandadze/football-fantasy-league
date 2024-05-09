<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = Country::pluck('id')->toArray();
        $positions = Position::pluck('id')->toArray();

        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'age' => $this->faker->numberBetween(18, 40),
            'market_price' => $this->faker->numberBetween(5, 20),
            'country_id' => $this->faker->randomElement($countries),
            'position_id' => $this->faker->randomElement($positions),
            'team_id' => \App\Models\Team::factory(),
        ];
    }
}
