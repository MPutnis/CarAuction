<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user is a guest
        if (Auth::guest()) {
            return redirect()->route('login')
                ->withErrors( 'You need to log in to place a bid.');
        }

        // Check if the user does not have a valid credit card
        if (Auth::user()->hasRole('userCCF')) {
            return redirect()->route('profile.edit', Auth::user()->id)
                ->withErrors( 'You need a valid credit card to place a bid.');
        }

        // admin check
        if (Auth::user()->hasRole('admin')) {
            return redirect()->back()
                ->withErrors( 'Admins cannot place bids.');
        }
        
        
        
        $request->validate([
            'auction_id' => 'required|exists:auctions,id',
            'amount' => 'required|numeric|min:100',
        ]);

        $auction = Auction::findOrFail($request->auction_id);
        
        $highestBid = $auction->bids->max('amount');
        $minBid = $highestBid ? $highestBid + 100 : 100;
        if ($request->amount < $minBid) {
            return redirect()->back()->with('error', 'Your bid must be at least ' . $minimumBid . '.');
        }

        $bid = new Bid();
        $bid->auction_id = $auction->id;
        $bid->user_id = auth()->id();
        $bid->amount = $request->amount;
        $bid->save();

        return redirect()->route('auctions.show', $auction->id)->with('success', 'Bid placed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
