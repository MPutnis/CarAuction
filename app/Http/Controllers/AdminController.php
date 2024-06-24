<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Auctions;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function approveCarForAuction($carId)
    {
        $car = Car::findOrfail($carId);
        if ($car->status !== Car::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Car is not pending for approval');
        }

        $car->status = Car::STATUS_APPROVED;
        $car->save();

        //create auction
        Auctions::create([
            'car_id' => $car->id,
            'start_time' => now(),
            'end_time' => now()->addDays(7),
        ]);

        return redirect()->back()->with('success', 'Car approved for auction');
    }

    public function denyCarForAuction($carId)
    {
        $car = Car::findOrfail($carId);
        if ($car->status !== Car::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Car is not pending for approval');
        }

        $car->status = Car::STATUS_DENIED;
        $car->save();

        return redirect()->back()->with('success', 'Car denied for auction');
    }

    public function finishAuction($auctionId)
    {
        $auction = Auctions::findOrfail($auctionId);
        if ($auction->car->status !== Car::STATUS_APPROVED) {
            return redirect()->back()->with('error', 'Car is not approved for auction');
        }

        $auction->car->status = Car::STATUS_FINISHED;
        $auction->car->save();

        return redirect()->back()->with('success', 'Auction finished');
    }
}
