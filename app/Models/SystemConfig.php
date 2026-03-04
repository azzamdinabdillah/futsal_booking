<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemConfig extends Model
{
    use HasFactory;

    protected $table = 'system_configs';

    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
        'description',
        'updated_at',
        'updated_by',
    ];

    /**
     * Get the admin who last updated the config.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
