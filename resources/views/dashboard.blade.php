@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

        @unlessrole('admin')
            <div>  
                <h2 class="text-xl font-semibold mb-2">Your Cars for Sale</h2>
                <div class="mb-4">
                    @foreach($auctions as $auction)
                        <a href="{{ route('auctions.show', $auction->id) }}" class="stretched-link text-blue-500 hover:underline">
                            
                            <x-auction-card
                                :auction="$auction"
                                :auctionStatus="$auction->status"
                            />
                            <div class="p-4">
                                
                            <p>
                                Auction Status: {{ $auction->status}}
                                @if($auction->status == 'pending')
                                    <a href="{{ route('auctions.edit', $auction->car->id) }}" class="text-blue-500 ml-2">Edit</a>
                                @endif
                            </p>
                        </a>
                    @endforeach
                </div>

                <h2 class="text-xl font-semibold mb-2">Auctions You've Bid On</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($bidAuctions as $auction)
                        <x-auction-card
                            :auction="$auction"
                            :auctionStatus="$auction->status"
                        />
                    @endforeach
                </div>
            </div>
        @endunlessrole
        @role('admin')
            <div>
                <h2 class="text-xl font-semibold mb-2">Pending Auctions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    @foreach($allAuctions as $auction)
                        @if($auction->status == 'pending')
                            <div class="flex flex-col min-h-[400px]" >
                                <x-auction-card
                                    :auction="$auction"
                                    :auctionStatus="'pending'"
                                />     
                        
                            
                                <a href="{{ route('auctions.edit', $auction->id) }}" class="text-blue-500 ml-2">Edit</a>
                            </div>    
                        @endif
                    @endforeach
                    
                </div>
            </div>
        @endrole           
    </div>
@endsection
