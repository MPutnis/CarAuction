<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Auction;
use Illuminate\Console\Command;

class UpdateAuctionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update auction status from approved to finished if end time is reached';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $auctions = Auction::where('status', 'approved')
                            ->where('end_time', '<=', $now)
                            ->get();

        foreach ($auctions as $auction) {
            $auction->status = 'finished';
            $auction->save();
        }

        return 0;
    }
}
