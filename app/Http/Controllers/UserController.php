<?php

namespace App\Http\Controllers;  // ← PERHATIAN: harus 'Controllers' (dengan 's')

use App\Models\Room;
use App\Models\Facility;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   
    public function dashboard()
    {
        $rooms = Room::where('status', 'available')->get();
        $facilities = Facility::where('status', 'available')
            ->where('quantity', '>', 0)
            ->get();

        return view('user.dashboard', compact('rooms', 'facilities'));
    }

    public function bookingForm($type, $id = null)
    {
        if ($type === 'room') {
            $bookable = Room::findOrFail($id);
        } elseif ($type === 'facility') {
            $bookable = Facility::findOrFail($id);
        } else {
            abort(404);
        }

        return view('user.booking-form', compact('bookable', 'type'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'bookable_type' => 'required|in:room,facility',
            'bookable_id' => 'required|integer',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string|max:500',
        ]);

        // Cek ketersediaan
        if ($request->bookable_type === 'room') {
            $bookable = Room::findOrFail($request->bookable_id);
            if ($bookable->status !== 'available') {
                return back()->withErrors(['error' => 'Ruangan tidak tersedia.'])->withInput();
            }
        } else {
            $bookable = Facility::findOrFail($request->bookable_id);
            if ($bookable->status !== 'available' || $bookable->quantity <= 0) {
                return back()->withErrors(['error' => 'Fasilitas tidak tersedia.'])->withInput();
            }
        }

        // Cek konflik waktu
        $conflict = Booking::where('bookable_type', $request->bookable_type === 'room' ? Room::class : Facility::class)
            ->where('bookable_id', $request->bookable_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['error' => 'Waktu sudah dipesan. Silakan pilih waktu lain.'])->withInput();
        }

        Booking::create([
            'user_id' => Auth::id(),
            'bookable_type' => $request->bookable_type === 'room' ? Room::class : Facility::class,
            'bookable_id' => $request->bookable_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return redirect()->route('user.history')->with('success', 'Booking berhasil diajukan. Menunggu persetujuan admin.');
    }

    public function history()
    {
        $bookings = Auth::user()->bookings()
            ->with('bookable')
            ->latest()
            ->get();

        return view('user.history', compact('bookings'));
    }
}