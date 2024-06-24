<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuctionsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\AdminController;

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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/approve-car/{car}', [AdminController::class, 'approveCarForAuction'])
        ->name('admin.approveCarForAuction');
    Route::post('/admin/deny-car/{car}', [AdminController::class, 'denyCarForAuction'])
        ->name('admin.denyCarForAuction');
    Route::post('/admin/finish-auction/{auction}', [AdminController::class, 'finishAuction'])
        ->name('admin.finishAuction');
});

Route::resource('auctions', AuctionsController::class);
// route for a single auction
Route::get('/auctions/{auction}', [AuctionsController::class, 'show'])->name('auctions.show');
Route::resource('cars', CarController::class);
Route::resource('bids', BidController::class);
Route::resource('comments', CommentsController::class);

require __DIR__.'/auth.php';
