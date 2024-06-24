<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    //auction statuses
    const STATUS_DENIED = 'denied';
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_FINISHED = 'finished';

    public function auctions()
    {
        return $this->hasOne(Auctions::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isDenied()
    {
        return $this->status === self::STATUS_DENIED;
    }

    public function isFinished()
    {
        return $this->status === self::STATUS_FINISHED;
    }
}


