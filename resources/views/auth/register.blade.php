@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <h3 class="text-center mb-4">Register</h3>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Phone (Optional)</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="mb-4">
                    <label>Register As</label>
                    <select name="role" class="form-select" required>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="mentor" {{ old('role') == 'mentor' ? 'selected' : '' }}>Mentor</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-decoration-none">Already have an account? Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
