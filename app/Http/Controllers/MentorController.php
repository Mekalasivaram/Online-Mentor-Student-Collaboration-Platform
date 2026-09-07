<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class MentorController extends Controller
{
    public function dashboard() {
        $bookings = Booking::where('mentor_id', Auth::user()->mentor->id)->with('student.user')->get();
        return view('mentor.dashboard', compact('bookings'));
    }
}
