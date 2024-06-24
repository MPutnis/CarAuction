<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Details</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-5">Auction Details</h1>
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-5">
            <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                @if($auction->car)
                    <h2 class="text-2xl font-semibold">Car: {{ $auction->car->make }} {{ $auction->car->model }}</h2>
                @else
                    <h2 class="text-2xl font-semibold">Car: Not Available</h2>
                @endif
                <p class="text-gray-700">Auction ID: {{ $auction->id }}</p>
                <p class="text-gray-700">Seller: {{ $auction->user->name }}</p>
                <p class="text-gray-700">Auction ends: {{ $auction->end_time }}</p>

                <h3 class="text-xl font-semibold mt-5">Bids</h3>
                @if($auction->bids->isEmpty())
                    <p class="text-gray-500">No bids yet.</p>
                @else
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach($auction->bids as $bid)
                            <li>{{ $bid->amount }} by {{ $bid->user->name }} at {{ $bid->created_at }}</li>
                        @endforeach
                    </ul>
                @endif

                <h3 class="text-xl font-semibold mt-5">Comments</h3>
                @if($auction->comments->isEmpty())
                    <p class="text-gray-500">No comments yet.</p>
                @else
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach($auction->comments as $comment)
                            <li>
                                <p>{{ $comment->content }}</p>
                                <h5>By: {{ $comment->user->name }}</h5>
                                <h6>At: {{ $comment->created_at }}</h6>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <a href="{{ route('auctions.index') }}" class="text-blue-500 hover:underline">Back to All Auctions</a>
    </div>
</body>
</html>
