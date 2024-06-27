@extends('layouts.app')

@section('title', 'Sell Car')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Sell Your Car</h1>

    <form action="{{ route('cars.update', $car->id )}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="make" class="block text-sm font-medium text-gray-700">Make</label>
            <input type="text" name="make" id="make" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('make', $car->make ) }}">
            @error('make')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
            <input type="text" name="model" id="model" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('model', $car->model) }}">
            @error('model')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
            <input type="number" name="year" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('year', $car->year) }}">
            @error('year')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="reserve_price" class="block text-sm font-medium text-gray-700">Reserve Price</label>
            <input type="number" step="0.01" name="reserve_price" id="reserve_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('reserve_price', $car->reserve_price) }}">
            @error('reserve_price')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="mileage" class="block text-sm font-medium text-gray-700">Mileage</label>
            <input type="number" name="mileage" id="mileage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('mileage', $car->mileage) }}">
            @error('mileage')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $car->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Car Data</button>
        </div>
    </form>

    <form action="{{ route('auctions.destroy', $car->auction->id) }}" method="POST" class="mt-4" 
        onsubmit="return confirm('Are you sure you want to delete this auction and its associated car?');"
    >
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Delete Auction</button>
    </form>
</div>
@endsection