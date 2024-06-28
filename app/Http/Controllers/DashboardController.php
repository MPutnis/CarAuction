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
        $bidAuctions = $user->bids->pluck('auction')->unique('id');
        // Get all auctions in order of creation
        $allAuctions = Auction::orderBy('created_at', 'asc')->get();
        
        return view('dashboard', [
            'auctions' => $userAuctions,
            'bidAuctions' => $bidAuctions,
            'allAuctions' => $allAuctions,
        ]);
    }
}
