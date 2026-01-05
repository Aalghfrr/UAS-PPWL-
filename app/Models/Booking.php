<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bookable_type',
        'bookable_id',
        'date',
        'start_time',
        'end_time',
        'purpose',
        'status',
        'admin_notes'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookable()
    {
        return $this->morphTo();
    }

    // Status Helper Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    // Get status badge color
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'badge-pending',
            'approved' => 'badge-approved',
            'rejected' => 'badge-rejected',
            'completed' => 'badge-completed',
            default => 'badge-pending'
        };
    }

    // Get type badge
    public function getTypeBadge()
    {
        return $this->bookable_type === 'App\Models\Room' ? 'Ruangan' : 'Fasilitas';
    }

    public function getTypeBadgeClass()
    {
        return $this->bookable_type === 'App\Models\Room' ? 'badge-room' : 'badge-facility';
    }

    // Format date
    public function getFormattedDate()
    {
        return $this->date ? $this->date->format('d/m/Y') : 'N/A';
    }

    // Format time range
    public function getTimeRange()
    {
        if ($this->start_time && $this->end_time) {
            return $this->start_time . ' - ' . $this->end_time;
        }
        return 'N/A';
    }

    // Format created_at
    public function getFormattedCreatedAt()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : 'N/A';
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByStatus($query, $status)
    {
        if ($status && in_array($status, ['pending', 'approved', 'rejected', 'completed'])) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeByType($query, $type)
    {
        if ($type === 'room') {
            return $query->where('bookable_type', 'App\Models\Room');
        } elseif ($type === 'facility') {
            return $query->where('bookable_type', 'App\Models\Facility');
        }
        return $query;
    }

    public function scopeByDate($query, $date)
    {
        if ($date) {
            return $query->whereDate('date', $date);
        }
        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('purpose', 'like', "%{$search}%");
        }
        return $query;
    }

    // Check if booking is active (approved and not completed)
    public function isActive()
    {
        return $this->status === 'approved';
    }

    // Check if booking can be approved
    public function canBeApproved()
    {
        return $this->isPending();
    }

    // Check if booking can be rejected
    public function canBeRejected()
    {
        return $this->isPending() || $this->isApproved();
    }

    // Check if booking can be completed
    public function canBeCompleted()
    {
        return $this->isApproved();
    }

    // Get item name (room or facility)
    public function getItemName()
    {
        return $this->bookable ? $this->bookable->name : 'Item dihapus';
    }

    // Get item code if facility
    public function getItemCode()
    {
        if ($this->bookable_type === 'App\Models\Facility' && $this->bookable) {
            return $this->bookable->code ?? 'N/A';
        }
        return null;
    }
}