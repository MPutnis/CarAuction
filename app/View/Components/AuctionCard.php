<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuctionCard extends Component
{
    public $auction;
    public $auctionStatus;
    /**
     * Create a new component instance.
     */
    public function __construct($auction, $auctionStatus)
    {
        
        $this->auction = $auction;
        $this->auctionStatus = $auctionStatus;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.auction-card');
    }
}
