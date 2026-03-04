<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlockedSlot extends Model
{
    use HasFactory;

    protected $table = 'blocked_slots';

    public $timestamps = false;

    protected $fillable = [
        'field_id',
        'blocked_date',
        'start_time',
        'end_time',
        'reason',
        'created_by',
        'created_at',
    ];

    protected $casts = [
        'blocked_date' => 'date',
    ];

    /**
     * Get the field that the slot belongs to.
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * Get the admin who created the blocked slot.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
