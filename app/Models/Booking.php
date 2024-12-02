<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expert_id',
        'expert_name',
        'user_name',
        'status',
        'timestamp',
        'note',
        'rate',
        'expert_address',
        'expert_image_url',
        'user_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }
}
