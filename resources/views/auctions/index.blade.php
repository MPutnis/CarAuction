@extends('layouts.app')

@section('title', 'All Auctions')

@section('hero')
    @if($heroAuction)
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-4">
                <a href="{{ route('auctions.show', $heroAuction->id) }}" class="stretched-link text-blue-500 hover:underline">
                    <div class="flex flex-col md:flex-row">
                        <!-- Display Image -->
                        <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-4">
                            @php
                                $imagePaths = json_decode($heroAuction->car->image_paths, true);
                                $image = !empty($imagePaths) ? asset('storage/' . $imagePaths[0]) : asset('images/stock-car.jpg');
                            @endphp
                            <img src="{{ $image }}" alt="Car Image" class="w-full h-auto md:w-48 md:h-32 object-cover">
                        </div>

                        <!-- Display Auction Details -->
                        <div>
                            <h2 class="text-2xl font-semibold">
                                Car: {{ $heroAuction->car->make }} {{ $heroAuction->car->model }}   
                            </h2>
                            <h3 class="text-xl font-semibold">Highest Bid: {{$heroAuction->bids->max('amount') ? $heroAuction->bids->max('amount') : 0 }}</h3>
                            <p class="text-gray-700">Auction ID: {{ $heroAuction->id }}</p>
                            <p class="text-gray-700">Seller: {{ $heroAuction->user->name }}</p>
                            <p class="text-gray-700">Auction ends: {{ $heroAuction->end_time }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endif
@endsection

@section('content')
    <div class="container mx-auto mt-5 mb-5">
        <h1 class="text-3xl font-bold mb-4">Ongoing Auctions</h1>
        @if($auctions->isEmpty())
            <p class="text-gray-700">There are no auctions.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($auctions as $auction)
                    
                    <x-auction-card
                        :auction="$auction"
                        :auctionStatus="'approved'"
                    />
                
                @endforeach
            </div>  
        @endif
    </div>
@endsection
