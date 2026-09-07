<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $fillable = [
        'user_id',
        'expertise',
        'experience',
        'bio',
        'availability',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function skills() {
        return $this->hasMany(Skill::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
