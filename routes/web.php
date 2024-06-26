<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;

use App\Http\Middleware\CheckCreditCardVerified;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', [AuctionController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// route for submitting a car for sale
Route::get('/auctions/create', 'AuctionController@create')
    ->middleware('permission:create auctions')
    ->name('auctions.create');

// route for users to edit their cars while auction status is pending
Route::get('/cars/{car}/edit', [CarController::class, 'edit'])
    ->middleware('auth')
    ->name('cars.edit'); 

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::post('/admin/approve-car/{car}', [AdminController::class, 'approveCarForAuction'])
//         ->name('admin.approveCarForAuction');
//     Route::post('/admin/deny-car/{car}', [AdminController::class, 'denyCarForAuction'])
//         ->name('admin.denyCarForAuction');
//     Route::post('/admin/finish-auction/{auction}', [AdminController::class, 'finishAuction'])
//         ->name('admin.finishAuction');
// });

Route::resource('auctions', AuctionController::class);
// route for a single auction
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
Route::resource('cars', CarController::class);
Route::resource('bids', BidController::class);
Route::resource('comments', CommentController::class);

require __DIR__.'/auth.php';
