<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'student_id',
        'mentor_id',
        'booking_date',
        'booking_time',
        'status',
        'otp',
        'rating',
        'feedback',
        'message',
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function mentor() {
        return $this->belongsTo(Mentor::class);
    }
}
