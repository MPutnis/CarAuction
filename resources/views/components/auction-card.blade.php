@if($auction->status == $auctionStatus)
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-0 mt-5">
        <div class="p-4">
            <a href="{{ route('auctions.show', $auction->id) }}" class="stretched-link text-blue-500 hover:underline">
                <div class="flex flex-col">
                    <div>
                        <h2 class="text-2xl font-semibold">
                            {{ $auction->car->make }} {{ $auction->car->model }}   
                        </h2>
                        <h3 class="text-xl font-semibold mb-2">Highest Bid: {{$auction->bids->max('amount') ? $auction->bids->max('amount') : 0 }}</h3>
                    </div>
                    <!-- Display Image -->
                    <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-4">
                        @php
                            $imagePaths = json_decode($auction->car->image_paths, true);
                            $image = !empty($imagePaths) ? asset('storage/' . $imagePaths[0]) : asset('images/stock-car.jpg');
                        @endphp
                        <img src="{{ $image }}" alt="Car Image" class="w-full h-auto md:w-48 md:h-32 object-cover">
                    </div>
                    <!-- Display Auction Details -->
                    <div>
                        <p class="text-gray-700">Auction ID: {{ $auction->id }}</p>
                        <p class="text-gray-700">Seller: {{ $auction->user->name }}</p>
                        <p class="text-gray-700">Auction ends: {{ $auction->end_time }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endif