@extends('layouts.app')
@section('content')
<h2>Mentor Dashboard</h2>
<div class="row mt-4">
    <div class="col-md-6 mb-3">
        <div class="card bg-info text-white p-3">
            <h4>Session Requests</h4>
            <h2>{{ $bookings->count() }}</h2>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card bg-success text-white p-3">
            <h4>Accepted Sessions</h4>
            <h2>{{ $bookings->where('status', 'accepted')->count() }}</h2>
        </div>
    </div>
</div>

<h4 class="mt-4">Booking Requests</h4>
<div class="card p-3">
    @if($bookings->isEmpty())
        <p class="text-muted">No requests yet.</p>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Date & Time</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->student->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }} <br> <small class="text-muted">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</small></td>
                        <td>{{ $booking->message ?? '-' }}</td>
                        <td>
                            @if($booking->status == 'pending') <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($booking->status == 'accepted') <span class="badge bg-info">Accepted</span>
                            @elseif($booking->status == 'completed') <span class="badge bg-success">Completed</span>
                            @else <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($booking->status == 'pending')
                                <form action="{{ route('mentor.booking.status', $booking) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit" class="btn btn-sm btn-success mb-1">Accept</button>
                                </form>
                                <form action="{{ route('mentor.booking.status', $booking) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-danger mb-1">Reject</button>
                                </form>
                            @elseif($booking->status == 'accepted')
                                <form action="{{ route('mentor.booking.status', $booking) }}" method="POST" class="d-inline d-flex align-items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <input type="text" name="otp" class="form-control form-control-sm w-auto" placeholder="Enter OTP" required style="max-width: 100px;">
                                    <button type="submit" class="btn btn-sm btn-primary">Complete</button>
                                </form>
                            @elseif($booking->status == 'completed' && $booking->rating)
                                <div class="text-warning">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= $booking->rating) <i class="bi bi-star-fill"></i> @else <i class="bi bi-star"></i> @endif
                                    @endfor
                                </div>
                                @if($booking->feedback)
                                    <small class="text-muted d-block mt-1 text-truncate" style="max-width: 150px;" title="{{ $booking->feedback }}">{{ $booking->feedback }}</small>
                                @endif
                            @else
                                <span class="text-muted">No Action</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
