<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
