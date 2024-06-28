@extends('layouts.app')

@section('title', 'Edit Auction')

@section('content')
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <x-auction-details 
            :car="$auction->car" 
            :auctionId="$auction->id" 
            :sellerName="$auction->user->name"
            :startTime="$auction->start_time" 
            :endTime="$auction->end_time"
        />
    </div>
    <div class="gallery mb-4">
        <h2 class="text-2xl font-bold mb-2">Gallery</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php
                $imagePaths = json_decode($auction->car->image_paths, true);
            @endphp
            @if (empty($imagePaths))
                <div class="hidden">
                    
                </div>
            @else
                @foreach(json_decode($auction->car->image_paths, true) as $image)
                    <div class="image">
                        <img src="{{ asset('storage/' . $image) }}" alt="Car Image" class="w-full h-auto">
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-bold my-4">Edit Auction</h1>
        <form action="{{ route('auctions.update', $auction->id) }}" method="POST" class="w-full max-w-lg mb-4">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                @php
                $statuses = ['denied', 'pending', 'approved', 'finished'];
                @endphp
                @foreach($statuses as $status)
                    <div class="form-check">
                        <input class="form-radio h-5 w-5 text-gray-600" type="radio" name="status" 
                            id="status_{{ $status }}" 
                            value="{{ $status }}" {{ $auction->status == $status ? 'checked' : '' }}
                        >
                        <label class="ml-2 text-gray-700" for="status_{{ $status }}">
                            {{ ucfirst($status) }}
                        </label>
                        @error('status')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
                <input type="date" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="start_date" name="start_date" value="{{ $auction->start_time ? (new DateTime($auction->start_time))->format('Y-m-d') : '' }}"
                >
                @error('start_date')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Auction</button>
        </form>
        @if($auction->isPending())
            <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST" class="mt-4" 
                onsubmit="return confirm('Are you sure you want to delete this auction and its associated car?');"
            >
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Delete Auction</button>
            </form>
        @endif
    </div>
@endsection
