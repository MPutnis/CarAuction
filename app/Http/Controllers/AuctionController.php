<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Auction;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $auctions = Auction::with(['car', 'user', 'bids' => function( $query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        //last bid
        $auctions->each(function ($auction) {
            $auction->last_bid = $auction->bids->first();
        });

        return view('auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->guest()) {
            return redirect()->route('login')
                ->withErrors('You must be logged in to create an auction.');
        }

        $user = Auth::user();

        if ($user->hasRole('userCCF')) {
            return redirect()->route('profile.edit')
                ->withErrors('You must verify your credit card before creating an auction.');
        }
        if ($user->can('create auctions')) {
            return view('auctions.create');
        }

        return redirect()->back()->withErrors('You do not have permission to create an auction.');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date("Y"),
            'reserve_price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try{
            $auction = new Auction();
            $auction->user_id = auth()->id();
            $auction->save();

            $car = new Car();
            $car->auction_id = $auction->id;
            $car->make = $request->make;
            $car->model = $request->model;
            $car->year = $request->year;
            $car->reserve_price = $request->reserve_price;
            $car->mileage = $request->mileage;
            $car->description = $request->description;
            $car->save();
            
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('car_images', 'public');
                    $imagePaths[] = $path;
                }
                $car->image_paths = json_encode($imagePaths);
                $car->save();
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Auction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors('An error occurred while creating the auction and car: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Auction $auction): View
    {
        $auction->load(['car', 'user', 'bids.user', 'comment.user']);
        return view('auctions.show', compact('auction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $auction = Auction::find($id);

        if(Auth::user()->id == $auction->user_id && $auction->isPending()) {
            $car = $auction->car;
            return view('cars.edit', compact('car'));
        
        } elseif (Auth::user()->hasRole('admin')) {
            return view('auctions.edit', compact('auction'));

        } else {
            // Redirect if conditions are not met
            return redirect()->route('dashboard')->withErrors( 'You cannot edit this auction.');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auction $auction)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,approved,denied,finished',
        ]);
        $aStatus = $auction->status;
        $rStatus = $request->status;
        $statusChanged = $aStatus !== $rStatus; //true if new status is different
        $startDate = $request->start_date;

        if($statusChanged) {

            if($aStatus === 'pending' && $rStatus === 'approved') {
                $validator->sometimes('start_date', 'nullable|date|after_or_equal:today', function($input) {
                    return true;
                });

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                if($request->start_date) {
                    $startTime = Carbon::createFromFormat('Y-m-d', $startDate)
                    ->startOfDay() 
                    ->toDateTimeString();
                } else {
                    $startTime = Carbon::now()->toDateTimeString();
                }

                $auction->status = $request->status;
                $auction->start_time = $startTime;
                $auction->end_time =  Carbon::parse($startTime)->addWeek()->toDateTimeString();
            
            } elseif( $aStatus === 'pending' && $rStatus === 'denied') {

                $aStatus = $rStatus;
                $auction->start_time = NULL;
                $auction->end_time = NULL;

            } elseif( $aStatus === 'approved' && $rStatus === 'finished') {
                
                // forced finish of an auction
                $aStatus = $rStatus;
                $auction->end_time = Carbon::now()->toDateTimeString(); 

            } else {

                return redirect()->back()->withErrors('Unsupported actions');
            }
        } else { //status didn't change
            
            if( $aStatus === 'approved') {
                //postpone auction start( if it is supposed to start after today)
                $validator->sometimes('start_date', 'required|date|after:today', function($input) {
                    return true;
                });

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $startTime = Carbon::createFromFormat('Y-m-d', $startDate)
                    ->startOfDay() 
                    ->toDateTimeString();
                $auction->start_time = $startTime;
                $auction->end_time =  Carbon::parse($startTime)->addWeek()->toDateTimeString();
            
            } else {

                return redirect()->back()->withErrors('Unsupported actions');
            }
        }

        // Save the updated auction to the database
        $auction->save();

        // Redirect the user with a success message
        return redirect()->route('auctions.show', $auction->id)
                        ->with('success', 'Auction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $auction = Auction::findOrFail($id);

        if ($auction->car) {
            $auction->car->delete();
        }
        $auction->delete();

        return redirect()->route('auctions.index')->with('success', 'Auction deleted successfully.');
    }
}
