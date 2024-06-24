<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Auctions;
use App\Models\Car;
use App\Models\Bid;
use App\Models\Comments;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();
        $cars = Car::factory(10)->create();
        
        $cars->each(function ($car) use ($users) {
            // assign random user to each auction
            $user = $users->random();
            $car->user_id = $user->id;
            
            $auction = Auctions::factory()->create([
                'car_id' => $car->id,
            ]);
            
            // create bids
            Bid::factory(10)->create([
                'user_id' => $users->random()->id, // random user for a bid
                'auctions_id' => $auction->id,
            ]);

            // create comments
            Comments::factory(10)->create([
                'user_id' => $users->random()->id, // random user for a comment
                'auctions_id' => $auction->id,
            ]);
        });
    }
}
