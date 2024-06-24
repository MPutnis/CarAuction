<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Auctions</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-5">
        <h1 class="text-3xl font-bold mb-4">All Auctions</h1>
        @if($auctions->isEmpty())
            <p class="text-gray-700">There are no auctions.</p>
        @else
            @foreach($auctions as $auction)
                <div class="bg-white shadow-md rounded-lg overflow-hidden mb-3">
                    <div class="p-4">
                        <a href="{{ route('auctions.show', $auction->id) }}" class="stretched-link text-blue-500 hover:underline">
                            <h2 class="text-2xl font-semibold">Car: {{ $auction->car->make }} {{ $auction->car->model }}</h2>
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
            @endforeach
        @endif
    </div>
</body>
</html>
