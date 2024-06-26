<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Auction;
use App\Models\Car;
use App\Models\Bid;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();
        $auctions = Auction::factory(10)->create();
        
        $auctions->each(function ($auction) use ($users) {
            
            Car::factory()->create([
                'auction_id' => $auction->id,
            ]);
            
            // create bids
            Bid::factory(10)->create([
                'user_id' => $users->random()->id, // random user for a bid
                'auction_id' => $auction->id,
            ]);

            // create comments
            Comment::factory(10)->create([
                'user_id' => $users->random()->id, // random user for a comment
                'auction_id' => $auction->id,
            ]);
        });
    }
}
