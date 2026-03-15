<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Booking;
use App\Models\SystemConfig;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        return redirect()->route('booking.create');
    }

    public function create(Request $request)
    {
        $fields = Field::where('status', 'active')->get();
        $selectedFieldId = $request->query('field_id', $fields->first()?->id);
        $selectedDate = $request->query('date', Carbon::now()->format('Y-m-d'));

        // Get bookings for the selected date and field to show availability
        $bookings = Booking::whereDate('play_date', $selectedDate)
            ->whereIn('status', ['confirmed', 'paid', 'completed', 'pending'])
            ->get(['field_id', 'start_time', 'end_time']);

        return Inertia::render('Booking/Create', [
            'fields' => $fields,
            'selectedFieldId' => (int) $selectedFieldId,
            'selectedDate' => $selectedDate,
            'bookings' => $bookings,
            'configs' => SystemConfig::getAllAsArray(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'customer_name' => 'required|string|max:255',
            'customer_whatsapp' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'play_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'payment_method' => 'required|in:transfer,cash',
            'policy_agreed' => 'required|accepted',
        ]);

        $field = Field::findOrFail($validated['field_id']);
        
        // Calculate duration and price
        $start = Carbon::parse($validated['play_date'] . ' ' . $validated['start_time']);
        $end = Carbon::parse($validated['play_date'] . ' ' . $validated['end_time']);
        $durationHours = $start->diffInMinutes($end) / 60;
        
        $totalPrice = $durationHours * $field->price_per_hour;
        
        // Get DP percentage from config
        $dpPercentage = (float) SystemConfig::getValue('dp_percentage', 30);
        $dpAmount = ($dpPercentage / 100) * $totalPrice;
        $remainingAmount = $totalPrice - $dpAmount;

        // Check for double booking
        $exists = Booking::where('field_id', $validated['field_id'])
            ->whereDate('play_date', $validated['play_date'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->whereIn('status', ['confirmed', 'paid', 'pending'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['start_time' => 'Jadwal ini sudah dibooking orang lain.']);
        }

        $booking = Booking::create([
            'booking_code' => 'BK-' . strtoupper(Str::random(8)),
            'field_id' => $validated['field_id'],
            'customer_name' => $validated['customer_name'],
            'customer_whatsapp' => $validated['customer_whatsapp'],
            'customer_email' => $validated['customer_email'],
            'play_date' => $validated['play_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'duration_hours' => $durationHours,
            'price_per_hour_snapshot' => $field->price_per_hour,
            'total_price' => $totalPrice,
            'payment_method' => $validated['payment_method'],
            'dp_percentage_snapshot' => $dpPercentage,
            'dp_amount' => $dpAmount,
            'remaining_amount' => $remainingAmount,
            'status' => 'pending',
            'policy_agreed' => true,
        ]);

        return redirect()->route('booking.success', $booking->id);
    }

    public function success(Booking $booking)
    {
        $booking->load('field');
        return Inertia::render('Booking/Success', [
            'booking' => $booking,
            'configs' => SystemConfig::getAllAsArray(),
        ]);
    }
}
