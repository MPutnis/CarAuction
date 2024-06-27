<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    protected $fillable = [
        'auction_id', 'make', 'model', 'year', 'reserve_price', 'mileage', 'description', 'image_paths'
    ];

    protected $casts = [
        'image_paths' => 'array', // Cast the image_paths field to an array
    ];

}


