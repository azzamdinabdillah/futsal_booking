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
     * Get config value by key.
     */
    public static function getValue(string $key, $default = null)
    {
        $config = self::where('key', $key)->first();
        return $config ? $config->value : $default;
    }

    /**
     * Get all configs as an associative array.
     */
    public static function getAllAsArray()
    {
        // Simple caching could be added here if needed
        return self::all()->pluck('value', 'key')->toArray();
    }

    /**
     * Get the admin who last updated the config.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
