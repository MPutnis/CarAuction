@extends('layouts.app')

@section('title', 'All Auctions')

@section('content')
    <div class="container mx-auto mt-5 mb-5">
        <h1 class="text-3xl font-bold mb-4">All Auctions</h1>
        @if($auctions->isEmpty())
            <p class="text-gray-700">There are no auctions.</p>
        @else
            @foreach($auctions as $auction)
                
                <x-auction-card
                    :auction="$auction"
                    :auctionStatus="'approved'"
                />
                
            @endforeach
        @endif
    </div>
@endsection
