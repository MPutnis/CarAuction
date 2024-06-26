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
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-bold my-4">Edit Auction</h1>
        <form action="{{ route('auctions.update', $auction->id) }}" method="POST" class="w-full max-w-lg">
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
                    </div>
                @endforeach
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
                <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="start_date" name="start_date" value="{{ $auction->start_time ? (new DateTime($auction->start_time))->format('Y-m-d') : '' }}">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Auction</button>
        </form>
    </div>
@endsection