<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Mentor;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create(Mentor $mentor) {
        return view('bookings.create', compact('mentor'));
    }

    public function store(Request $request) {
        $request->validate([
            'mentor_id' => 'required|exists:mentors,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'message' => 'nullable|string'
        ]);

        Booking::create([
            'student_id' => Auth::user()->student->id,
            'mentor_id' => $request->mentor_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Booking created successfully!');
    }

    public function updateStatus(Request $request, Booking $booking) {
        $request->validate([
            'status' => 'required|in:accepted,rejected,completed',
            'otp' => 'required_if:status,completed'
        ]);

        if ($request->status == 'accepted' && $booking->status != 'accepted') {
            $booking->otp = strtoupper(substr(uniqid(), -6));
        }

        if ($request->status == 'completed') {
            if (!$booking->otp || $booking->otp !== $request->otp) {
                return back()->with('error', 'Invalid OTP provided. Please ask the student for the correct OTP.');
            }
        }
        
        $booking->status = $request->status;
        $booking->save();
        
        return back()->with('success', 'Booking status updated!');
    }

    public function submitFeedback(Request $request, Booking $booking) {
        if ($booking->student_id !== Auth::user()->student->id || $booking->status !== 'completed') {
            return back()->with('error', 'You cannot leave feedback for this session.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:500'
        ]);

        $booking->update([
            'rating' => $request->rating,
            'feedback' => $request->feedback
        ]);

        return back()->with('success', 'Thank you! Your feedback has been submitted.');
    }
}
