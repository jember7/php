<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Expert extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'full_name', 'email', 'password', 'profession', 'date_of_birth', 'address', 'phone_number', 'profile_image', 'role'
    ];

    // Reverse relationship (one expert belongs to one user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

