<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mentor;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard() {
        $bookings = Booking::where('student_id', Auth::user()->student->id)->with('mentor.user')->get();
        return view('student.dashboard', compact('bookings'));
    }

    public function searchMentors(Request $request) {
        $query = Mentor::with('user', 'skills');
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('skills', function($q) use ($search) {
                $q->where('skill_name', 'like', "%{$search}%");
            })->orWhereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        $mentors = $query->paginate(10);
        return view('mentors.index', compact('mentors'));
    }
}
