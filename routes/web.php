<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuctionsController;
use App\Http\Controllers\CommentsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('auctions', AuctionsController::class);
// route for a single auction
Route::get('/auctions/{auction}', [AuctionsController::class, 'show'])->name('auctions.show');
Route::resource('cars', CarController::class);
Route::resource('bids', BidController::class);
Route::resource('comments', CommentsController::class);

require __DIR__.'/auth.php';