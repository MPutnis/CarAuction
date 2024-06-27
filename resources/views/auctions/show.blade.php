@extends('layouts.app')

@section('title', 'Auction Details')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-5">Auction Details</h1>
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-5">
            <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                <!-- auction details component -->
                <x-auction-details 
                    :car="$auction->car" 
                    :auctionId="$auction->id" 
                    :sellerName="$auction->user->name"
                    :startTime="$auction->start_time" 
                    :endTime="$auction->end_time" 
                />

                <!-- Place Bid Form -->
                <div class="my-4">
                    <h2 class="text-2xl font-bold mb-2">Place a Bid</h2>
                    <form action="{{ route('bids.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="auction_id" value="{{ $auction->id }}">
                        <div class="mb-4">
                            <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Bid Amount</label>
                            <input type="number" name="amount" id="amount"
                                value="{{$auction->bids->max('amount') ? $auction->bids->max('amount') + 100 : 100 }}"
                                min="{{$auction->bids->max('amount') ? $auction->bids->max('amount') + 100 : 100 }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required
                            >
                            @error('amount')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Place Bid</button>
                    </form>
                </div>

                <!-- bid history component -->
                <x-bid-history 
                    :bids="$auction->bids" 
                />

                <!-- Comment Form -->
                <div class="my-4">
                    <h2 class="text-2xl font-bold mb-2">Add a Comment</h2>
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="auction_id" value="{{ $auction->id }}">
                        <div class="mb-4">
                            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Comment</label>
                            <textarea name="content" id="content" rows="4"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required></textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Post Comment</button>
                    </form>
                </div>

                <!-- comment section component -->
                <x-comment-section 
                    :comments="$auction->comment"
                />
            </div>
        </div>
        <a href="{{ route('auctions.index') }}" class="text-blue-500 hover:underline">Back to All Auctions</a>
    </div>
@endsection
