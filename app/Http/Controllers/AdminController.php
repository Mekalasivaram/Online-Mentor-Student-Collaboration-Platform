<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;

class AdminController extends Controller
{
    public function dashboard() {
        $users = User::all();
        $bookings = Booking::with('student', 'mentor')->get();
        return view('admin.dashboard', compact('users', 'bookings'));
    }
}
