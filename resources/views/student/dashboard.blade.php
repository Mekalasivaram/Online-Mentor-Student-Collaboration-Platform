@extends('layouts.app')
@section('content')
<h2>Student Dashboard</h2>
<div class="row mt-4">
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white p-3">
            <h4>Total Bookings</h4>
            <h2>{{ $bookings->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white p-3">
            <h4>Completed Sessions</h4>
            <h2>{{ $bookings->where('status', 'completed')->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <a href="{{ route('student.mentors') }}" class="text-decoration-none">
            <div class="card bg-light text-dark p-3 text-center border-primary h-100 justify-content-center">
                <h5 class="mb-0 text-primary">Find a Mentor &rarr;</h5>
            </div>
        </a>
    </div>
</div>

<h4 class="mt-4">My Bookings</h4>
<div class="card p-3">
    @if($bookings->isEmpty())
        <p class="text-muted">No bookings yet.</p>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Mentor</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>OTP</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->mentor->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }} <br> <small class="text-muted">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</small></td>
                        <td>
                            @if($booking->status == 'pending') <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($booking->status == 'accepted') <span class="badge bg-info">Accepted</span>
                            @elseif($booking->status == 'completed') <span class="badge bg-success">Completed</span>
                            @else <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($booking->status == 'accepted' && $booking->otp)
                                <div class="bg-light px-2 py-1 border rounded text-center font-monospace fw-bold" style="letter-spacing: 2px;">{{ $booking->otp }}</div>
                            @elseif($booking->status == 'completed')
                                @if(!$booking->rating)
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $booking->id }}">Leave Feedback</button>
                                @else
                                    <div class="text-warning">
                                        @for($i=1; $i<=5; $i++)
                                            @if($i <= $booking->rating) <i class="bi bi-star-fill"></i> @else <i class="bi bi-star"></i> @endif
                                        @endfor
                                    </div>
                                    @if($booking->feedback)
                                        <small class="text-muted d-block mt-1 text-truncate" style="max-width: 150px;" title="{{ $booking->feedback }}">{{ $booking->feedback }}</small>
                                    @endif
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $booking->message ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Modals -->
@foreach($bookings as $booking)
    @if($booking->status == 'completed' && !$booking->rating)
    <div class="modal fade" id="feedbackModal{{ $booking->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('student.booking.feedback', $booking) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Leave Feedback for {{ $booking->mentor->user->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select" required>
                                <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                <option value="3">⭐⭐⭐ (3/5)</option>
                                <option value="2">⭐⭐ (2/5)</option>
                                <option value="1">⭐ (1/5)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Review/Feedback (Optional)</label>
                            <textarea name="feedback" class="form-control" rows="3" placeholder="How was the session?"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection
