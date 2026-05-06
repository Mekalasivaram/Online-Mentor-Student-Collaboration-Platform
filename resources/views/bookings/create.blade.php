@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <h3 class="mb-4">Book Session with {{ $mentor->user->name }}</h3>
            
            <div class="mb-4 bg-light p-3 rounded border">
                <strong>Expertise:</strong> {{ $mentor->expertise ?? 'N/A' }}<br>
                <strong>Availability:</strong> {{ $mentor->availability ?? 'Not specified' }}
            </div>

            <form action="{{ route('student.book.store') }}" method="POST">
                @csrf
                <input type="hidden" name="mentor_id" value="{{ $mentor->id }}">
                
                <div class="mb-3">
                    <label>Preferred Date</label>
                    <input type="date" name="booking_date" class="form-control" required min="{{ date('Y-m-d') }}">
                </div>
                
                <div class="mb-3">
                    <label>Preferred Time</label>
                    <input type="time" name="booking_time" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label>Message (Optional)</label>
                    <textarea name="message" class="form-control" rows="3" placeholder="What would you like to discuss?"></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Submit Booking Request</button>
            </form>
        </div>
    </div>
</div>
@endsection
