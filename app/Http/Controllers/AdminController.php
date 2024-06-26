<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Auction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function approveCarForAuction($auctionId)
    {
        $auction = Auction::findOrfail($auctionId);
        if ($auction->status !== Auction::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Car is not pending for approval');
        }

        $auction->status = Auction::STATUS_APPROVED;
        $auction->save();

        //create auction
        Auction::create([
            'car_id' => $auction->id,
            'start_time' => now(),
            'end_time' => now()->addDays(7),
        ]);

        return redirect()->back()->with('success', 'Car approved for auction');
    }

    public function denyCarForAuction($auctionId)
    {
        $auction = Car::findOrfail($auctionId);
        if ($auction->status !== Auction::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Car is not pending for approval');
        }

        $auction->status = Auction::STATUS_DENIED;
        $auction->save();

        return redirect()->back()->with('success', 'Car denied for auction');
    }

    public function finishAuction($auctionId)
    {
        $auction = Auction::findOrfail($auctionId);
        if ($auction->status !== Auction::STATUS_APPROVED) {
            return redirect()->back()->with('error', 'Car is not approved for auction');
        }

        $auction->status = Auction::STATUS_FINISHED;
        $auction->save();

        return redirect()->back()->with('success', 'Auction finished');
    }
}
