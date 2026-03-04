<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'field_id',
        'field_rating_score',
        'field_rating_comment',
        'service_rating_score',
        'service_rating_comment',
        'is_deleted',
        'deleted_by',
        'deleted_at',
    ];

    protected $casts = [
        'field_rating_score' => 'integer',
        'service_rating_score' => 'integer',
        'is_deleted' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the booking that the review belongs to.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the field that the review belongs to.
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * Get the admin who deleted the review.
     */
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'deleted_by');
    }
}
