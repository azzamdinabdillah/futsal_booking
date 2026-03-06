<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Field;
use App\Models\Booking;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));

        $fields = Field::with('photos')->where('status', 'active')->get()->map(function ($field) {
            $photo = $field->photos->first();
            return [
                'id' => $field->id,
                'name' => $field->name,
                'type' => $field->surface_type,
                'location' => $field->roof_type ?? 'Indoor',
                'size' => $field->length_m . 'x' . $field->width_m . 'm',
                'price' => 'Rp ' . number_format($field->price_per_hour, 0, ',', '.'),
                'image' => $photo ? (str_starts_with($photo->photo_url, 'assets/') ? '/' . $photo->photo_url : '/storage/' . $photo->photo_url) : '/assets/images/futsal-1.jpg',
            ];
        });

        // Get confirmed/paid bookings for the selected date
        $bookings = Booking::whereDate('play_date', $date)
            ->whereIn('status', ['confirmed', 'paid', 'completed']) // Adjust statuses as needed based on your business logic
            ->get(['field_id', 'start_time', 'end_time'])
            ->map(function ($booking) {
                return [
                    'field_id' => $booking->field_id,
                    'start' => Carbon::parse($booking->start_time)->format('H:i'),
                    'end' => Carbon::parse($booking->end_time)->format('H:i'),
                ];
            });

        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'fields' => $fields,
            'initialBookings' => $bookings,
            'initialDate' => $date,
        ]);
    }
}
