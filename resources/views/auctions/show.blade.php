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

                <!-- bid history component -->
                <x-bid-history 
                    :bids="$auction->bids" 
                />

                <!-- comment section component -->
                <x-comment-section 
                    :comments="$auction->comment"
                />
            </div>
        </div>
        <a href="{{ route('auctions.index') }}" class="text-blue-500 hover:underline">Back to All Auctions</a>
    </div>
@endsection
