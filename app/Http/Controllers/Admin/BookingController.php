<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('field')
            // Pending status first, then by created_at desc
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/Booking/Index', [
            'bookings' => $bookings,
        ]);
    }

    public function show(Booking $booking)
    {
        return Inertia::render('Admin/Booking/Show', [
            'booking' => $booking->load('field', 'review')
        ]);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $booking->update([
            'status' => $request->status,
            'confirmed_at' => $request->status === 'confirmed' ? now() : $booking->confirmed_at,
            'confirmed_by' => $request->status === 'confirmed' ? Auth::id() : $booking->confirmed_by,
            'completed_at' => $request->status === 'completed' ? now() : $booking->completed_at,
            'cancelled_at' => $request->status === 'cancelled' ? now() : $booking->cancelled_at,
            'cancelled_by' => $request->status === 'cancelled' ? Auth::id() : $booking->cancelled_by,
        ]);

        return redirect()->back()->with('success', 'Status booking berhasil diperbarui.');
    }
}
