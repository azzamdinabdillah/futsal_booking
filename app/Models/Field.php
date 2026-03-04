<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Field extends Model
{
    use HasFactory;

    protected $table = 'fields';

    protected $fillable = [
        'name',
        'price_per_hour',
        'length_m',
        'width_m',
        'surface_type',
        'roof_type',
        'player_capacity',
        'description',
        'status',
        'inactive_reason',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(FieldPhoto::class, 'field_id');
    }

    /**
     * Get the reviews for the field.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
