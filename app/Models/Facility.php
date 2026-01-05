<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'quantity',
        'status',
        'description',
        'image'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    // Helper method untuk cek ketersediaan
    public function isAvailable()
    {
        return $this->status === 'available' && $this->quantity > 0;
    }

    // Scope untuk yang tersedia
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('quantity', '>', 0);
    }
}