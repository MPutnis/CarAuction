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
        $auctions = Auction::factory(100)->create();
        
        $auctions->each(function ($auction) use ($users) {
            
            Car::factory()->create([
                'auction_id' => $auction->id,
            ]);
            
            // create bids
            $users->random(10)->each(function ($user) use ($auction) {
                Bid::factory()->create([
                    'user_id' => $user->id, // Each bid from a different user
                    'auction_id' => $auction->id,
                ]);
            });
            
            // create comments
            $users->random(10)->each(function ($user) use ($auction) {
                Comment::factory()->create([
                    'user_id' => $user->id, // Each comment from a different user
                    'auction_id' => $auction->id,
                ]);
            });
        });
    }
}
