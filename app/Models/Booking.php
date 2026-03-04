<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'field_id',
        'customer_name',
        'customer_whatsapp',
        'customer_email',
        'play_date',
        'start_time',
        'end_time',
        'duration_hours',
        'price_per_hour_snapshot',
        'total_price',
        'payment_method',
        'dp_percentage_snapshot',
        'dp_amount',
        'remaining_amount',
        'status',
        'policy_agreed',
        'admin_note',
        'rating_token',
        'confirmed_at',
        'confirmed_by',
        'completed_at',
        'cancelled_at',
        'cancelled_by',
        'dp_refunded',
    ];

    protected $casts = [
        'play_date' => 'date',
        'policy_agreed' => 'boolean',
        'dp_refunded' => 'boolean',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'duration_hours' => 'decimal:2',
        'price_per_hour_snapshot' => 'decimal:2',
        'total_price' => 'decimal:2',
        'dp_percentage_snapshot' => 'decimal:2',
        'dp_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    /**
     * Get the field that the booking belongs to.
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * Get the admin who confirmed the booking.
     */
    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'confirmed_by');
    }
}
