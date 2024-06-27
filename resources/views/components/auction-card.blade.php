@if($auction->status == $auctionStatus)
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-0 mt-5">
        <div class="p-4">
            <a href="{{ route('auctions.show', $auction->id) }}" class="stretched-link text-blue-500 hover:underline">
                <h2 class="text-2xl font-semibold">Car: {{ $auction->car->make }} {{ $auction->car->model }}</h2>
                <h3 class="text-xl font-semibold">Highest Bid: {{$auction->bids->max('amount') ? $auction->bids->max('amount') : 0 }}</h3>
                <p class="text-gray-700">Auction ID: {{ $auction->id }}</p>
                <p class="text-gray-700">Seller: {{ $auction->user->name }}</p>
                <p class="text-gray-700">
                    @if($auction->last_bid)
                        Last bid: {{ $auction->last_bid->amount }} by {{ $auction->last_bid->user->name }}
                    @else
                        No bids yet
                    @endif
                </p>
                <p class="text-gray-700">Auction ends: {{ $auction->end_time }}</p>
            </a>
        </div>
    </div>
@endif