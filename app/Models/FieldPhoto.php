<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldPhoto extends Model
{
    use HasFactory;

    protected $table = 'field_photos';

    public $timestamps = false;

    protected $fillable = [
        'field_id',
        'photo_url',
        'sort_order',
        'created_at',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }
}
