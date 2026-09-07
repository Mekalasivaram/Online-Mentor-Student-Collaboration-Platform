<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'college',
        'course',
        'year',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
