<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class User extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['full_name', 'email', 'password', 'address','phone_number',  'role']; // Add 'address' here

    


    // If users have many experts
    public function expert()
    {
        return $this->hasOne(Expert::class);
    }
}
