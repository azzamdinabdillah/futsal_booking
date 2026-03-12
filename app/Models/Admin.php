<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'full_name',
        'username',
        'password_hash',
        'email',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
