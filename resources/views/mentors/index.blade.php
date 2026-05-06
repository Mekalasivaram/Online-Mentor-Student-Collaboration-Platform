@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Find a Mentor</h2>
    <form action="{{ route('student.mentors') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by name or skill..." value="{{ request('search') }}">
        <button class="btn btn-outline-primary" type="submit">Search</button>
    </form>
</div>

<div class="row">
    @forelse($mentors as $mentor)
        <div class="col-md-4 mb-4">
            <div class="card h-100 p-3">
                <h5 class="fw-bold">{{ $mentor->user->name }}</h5>
                <p class="text-muted small mb-2">{{ $mentor->expertise ?? 'General Mentor' }}</p>
                <p class="small text-truncate" style="max-height: 40px;">{{ $mentor->bio ?? 'No bio available.' }}</p>
                <div class="mb-3">
                    <small><strong>Experience:</strong> {{ $mentor->experience ?? 'Not specified' }}</small>
                </div>
                <div class="mt-auto">
                    <a href="{{ route('student.book.create', $mentor) }}" class="btn btn-primary w-100">Book Session</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">No mentors found matching your search.</div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $mentors->links('pagination::bootstrap-5') }}
</div>
@endsection
