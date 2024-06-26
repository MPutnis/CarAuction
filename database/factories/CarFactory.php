<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\User;
use App\Models\Auction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'auction_id' => Auction::factory(),
            'make' => $this->faker->word,
            'model' => $this->faker->word,
            'year' => $this->faker->year,
            'reserve_price' => $this->faker->randomFloat(2, 1000, 100000),
            'mileage' => $this->faker->numberBetween(1, 999999),
            'description' => $this->faker->sentence,
        ];
    }
}
