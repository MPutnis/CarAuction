<?php


namespace Database\Factories;

use App\Models\Bid;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Auctions;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bid>
 */
class BidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'auctions_id' => Auctions::factory(),
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 1000, 100000),
        ];
    }
}
