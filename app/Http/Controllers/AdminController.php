<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Facility;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Helper method untuk pengecekan admin
    private function checkAdmin()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('user.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
    }

    public function dashboard()
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $totalRooms = Room::count();
        $totalFacilities = Facility::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $rejectedBookings = Booking::where('status', 'rejected')->count();

        $pendingApprovals = Booking::with(['user', 'bookable'])
            ->where('status', 'pending')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'totalFacilities',
            'pendingBookings',
            'rejectedBookings',
            'pendingApprovals'
        ));
    }

    public function rooms(Request $request)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $rooms = Room::orderBy('updated_at', 'desc')->get();
        
        return view('admin.rooms', compact('rooms'))
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
    }

    public function getRoom($id)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $room = Room::findOrFail($id);
        return response()->json($room);
    }

    public function storeRoom(Request $request)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:rooms,code',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,maintenance,unavailable',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $imagePath;
        }

        try {
            DB::table('rooms')->insert([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'capacity' => (int) $validated['capacity'],
                'status' => $validated['status'],
                'description' => $validated['description'] ?? '',
                'image' => $validated['image'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return redirect()->route('admin.rooms')
                ->with('success', 'Ruangan berhasil ditambahkan.')
                ->withHeaders([
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]);
            
        } catch (\Exception $e) {
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            return redirect()->route('admin.rooms')
                ->with('error', 'Gagal menambahkan ruangan.')
                ->withInput();
        }
    }

    public function updateRoom(Request $request, $id)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $room = Room::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:rooms,code,' . $room->id,
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,maintenance,unavailable',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);
        
        // Handle remove image
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
                $validated['image'] = null;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $imagePath = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $imagePath;
        } elseif (!isset($validated['image'])) {
            $validated['image'] = $room->image;
        }

        try {
            $updated = DB::table('rooms')
                ->where('id', $id)
                ->update([
                    'name' => $validated['name'],
                    'code' => $validated['code'],
                    'capacity' => $validated['capacity'],
                    'status' => $validated['status'],
                    'description' => $validated['description'] ?? '',
                    'image' => $validated['image'],
                    'updated_at' => now(),
                ]);
            
            if ($updated) {
                return redirect()->route('admin.rooms')
                    ->with('success', 'Ruangan berhasil diperbarui!')
                    ->withHeaders([
                        'Cache-Control' => 'no-cache, no-store, must-revalidate',
                        'Pragma' => 'no-cache',
                        'Expires' => '0'
                    ]);
            } else {
                return redirect()->route('admin.rooms')
                    ->with('error', 'Gagal memperbarui ruangan.')
                    ->withHeaders([
                        'Cache-Control' => 'no-cache, no-store, must-revalidate',
                        'Pragma' => 'no-cache',
                        'Expires' => '0'
                    ]);
            }
                
        } catch (\Exception $e) {
            return redirect()->route('admin.rooms')
                ->with('error', 'Gagal memperbarui ruangan.')
                ->withHeaders([
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]);
        }
    }

    public function deleteRoom($id)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $room = Room::findOrFail($id);
        
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }
        
        $room->delete();
        
        return redirect()->route('admin.rooms')
            ->with('success', 'Ruangan berhasil dihapus.')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
    }

    // ⚡ FACILITIES METHODS - PERBAIKAN UTAMA
    public function facilities(Request $request)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $facilities = Facility::orderBy('updated_at', 'desc')->get();
        
        return view('admin.facilities', compact('facilities'))
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
    }

    public function storeFacility(Request $request)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:facilities,code',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:available,maintenance,unavailable',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('facilities', 'public');
            $validated['image'] = $imagePath;
        } else {
            $validated['image'] = null;
        }
        
        try {
            Facility::create($validated);
            
            return redirect()->route('admin.facilities')
                ->with('success', 'Fasilitas berhasil ditambahkan!')
                ->withHeaders([
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]);
                
        } catch (\Exception $e) {
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            return redirect()->route('admin.facilities')
                ->with('error', 'Gagal menambahkan fasilitas.')
                ->withInput();
        }
    }

    public function updateFacility(Request $request, $id)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $facility = Facility::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:facilities,code,' . $id,
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:available,maintenance,unavailable',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);
        
        // Inisialisasi data update
        $updateData = [
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'quantity' => $validated['quantity'],
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
            'updated_at' => now(),
        ];
        
        // Handle remove image
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($facility->image && Storage::disk('public')->exists($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }
            $updateData['image'] = null;
        }
        // Handle new image upload
        elseif ($request->hasFile('image')) {
            if ($facility->image && Storage::disk('public')->exists($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }
            
            $imagePath = $request->file('image')->store('facilities', 'public');
            $updateData['image'] = $imagePath;
        } else {
            // Keep old image if no new upload and not removing
            $updateData['image'] = $facility->image;
        }
        
        try {
            $updated = DB::table('facilities')
                ->where('id', $id)
                ->update($updateData);
            
            if ($updated) {
                return redirect()->route('admin.facilities')
                    ->with('success', 'Fasilitas berhasil diperbarui!')
                    ->withHeaders([
                        'Cache-Control' => 'no-cache, no-store, must-revalidate',
                        'Pragma' => 'no-cache',
                        'Expires' => '0'
                    ]);
            } else {
                return redirect()->route('admin.facilities')
                    ->with('error', 'Gagal memperbarui fasilitas.')
                    ->withHeaders([
                        'Cache-Control' => 'no-cache, no-store, must-revalidate',
                        'Pragma' => 'no-cache',
                        'Expires' => '0'
                    ]);
            }
                
        } catch (\Exception $e) {
            return redirect()->route('admin.facilities')
                ->with('error', 'Gagal memperbarui fasilitas.')
                ->withInput();
        }
    }

    public function deleteFacility($id)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $facility = Facility::findOrFail($id);
        
        if ($facility->image && Storage::disk('public')->exists($facility->image)) {
            Storage::disk('public')->delete($facility->image);
        }
        
        $facility->delete();
        
        return redirect()->route('admin.facilities')
            ->with('success', 'Fasilitas berhasil dihapus.')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
    }

    public function allBookings(Request $request)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $query = Booking::with(['user', 'bookable'])
            ->orderBy('created_at', 'desc');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('type') && $request->type != '') {
            if ($request->type === 'room') {
                $query->where('bookable_type', 'App\Models\Room');
            } elseif ($request->type === 'facility') {
                $query->where('bookable_type', 'App\Models\Facility');
            }
        }
        
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $bookings = $query->paginate(20);
        
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'approved' => Booking::where('status', 'approved')->count(),
            'rejected' => Booking::where('status', 'rejected')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
        ];
        
        return view('admin.bookings', compact('bookings', 'stats'))
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
    }

    public function approveBooking(Request $request, $id)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes
        ]);

        if ($booking->bookable_type === 'App\Models\Facility') {
            $facility = $booking->bookable;
            if ($facility && $facility->quantity > 0) {
                $facility->decrement('quantity');
                if ($facility->quantity == 0) {
                    $facility->update(['status' => 'unavailable']);
                }
            }
        }

        return redirect()->back()->with('success', 'Booking berhasil disetujui.');
    }

    public function rejectBooking(Request $request, $id)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes ?? 'Booking ditolak oleh admin'
        ]);

        if ($booking->getOriginal('status') === 'approved' && $booking->bookable_type === 'App\Models\Facility') {
            $facility = $booking->bookable;
            if ($facility) {
                $facility->increment('quantity');
                if ($facility->quantity > 0 && $facility->status === 'unavailable') {
                    $facility->update(['status' => 'available']);
                }
            }
        }

        return redirect()->back()->with('success', 'Booking berhasil ditolak.');
    }

    public function completeBooking($id)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $booking = Booking::findOrFail($id);
        
        if ($booking->bookable_type === 'App\Models\Facility') {
            $facility = $booking->bookable;
            if ($facility) {
                $facility->increment('quantity');
                if ($facility->quantity > 0 && $facility->status === 'unavailable') {
                    $facility->update(['status' => 'available']);
                }
            }
        }
        
        $booking->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Booking diselesaikan.');
    }

    public function getBooking($id)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $booking = Booking::with(['user', 'bookable'])->findOrFail($id);
        return response()->json($booking);
    }

    public function getFacility($id)
    {
        // Cek admin
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }
        
        $facility = Facility::findOrFail($id);
        return response()->json($facility);
    }
}