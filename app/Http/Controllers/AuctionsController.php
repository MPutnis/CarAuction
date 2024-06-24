<?php

namespace App\Http\Controllers;

use App\Models\Auctions;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AuctionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $auctions = Auctions::with(['car', 'user', 'bids' => function( $query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        //last bid
        $auctions->each(function ($auction) {
            $auction->last_bid = $auction->bids->first();
        });

        return view('auctions.index', compact('auctions'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Auctions $auction): View
    {
        $auction->load(['car', 'user', 'bids.user', 'comments.user']);
        return view('auctions.show', compact('auction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auctions $auctions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auctions $auctions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auctions $auctions)
    {
        //
    }
}
