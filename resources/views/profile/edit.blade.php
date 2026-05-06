@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h3 class="mb-4">Edit Profile</h3>
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                
                <h5 class="text-primary mb-3">Basic Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Email Address</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                        <small class="text-muted">Email cannot be changed.</small>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>

                @if($user->role === 'mentor')
                    <hr>
                    <h5 class="text-primary mb-3 mt-4">Mentor Details</h5>
                    <div class="mb-3">
                        <label>Expertise</label>
                        <input type="text" name="expertise" class="form-control" value="{{ $user->mentor->expertise }}">
                    </div>
                    <div class="mb-3">
                        <label>Years of Experience</label>
                        <input type="text" name="experience" class="form-control" value="{{ $user->mentor->experience }}">
                    </div>
                    <div class="mb-3">
                        <label>Availability (e.g. Weekends 10 AM - 2 PM)</label>
                        <input type="text" name="availability" class="form-control" value="{{ $user->mentor->availability }}">
                    </div>
                    <div class="mb-4">
                        <label>Bio</label>
                        <textarea name="bio" class="form-control" rows="4">{{ $user->mentor->bio }}</textarea>
                    </div>
                @elseif($user->role === 'student')
                    <hr>
                    <h5 class="text-primary mb-3 mt-4">Student Details</h5>
                    <div class="mb-3">
                        <label>College / University</label>
                        <input type="text" name="college" class="form-control" value="{{ $user->student->college }}">
                    </div>
                    <div class="mb-3">
                        <label>Course / Major</label>
                        <input type="text" name="course" class="form-control" value="{{ $user->student->course }}">
                    </div>
                    <div class="mb-4">
                        <label>Year of Study</label>
                        <input type="text" name="year" class="form-control" value="{{ $user->student->year }}">
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection
