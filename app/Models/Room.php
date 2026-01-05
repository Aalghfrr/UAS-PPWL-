<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'quantity',
        'condition',
        'description'
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }
}