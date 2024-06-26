<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date("Y"),
            'reserve_price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'description' => 'required|string',
        ]);
        
        DB::beginTransaction();
        try{
            $car = Car::findOrFail($id);
            $car->make = $request->make;
            $car->model = $request->model;
            $car->year = $request->year;
            $car->reserve_price = $request->reserve_price;
            $car->mileage = $request->mileage;
            $car->description = $request->description;
            $car->save();
            
            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Car data updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors('An error occurred while updating car data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
