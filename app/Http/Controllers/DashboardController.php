<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get user's auctions
        $userAuctions = $user->auction;
        $bidAuctions = $user->bids;
        $allAuctions = Auction::all();
        
        return view('dashboard', [
            'auctions' => $userAuctions,
            'bidAuctions' => $bidAuctions,
            'allAuctions' => $allAuctions,
        ]);
    }
}
