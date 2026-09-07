@extends('layouts.app')
@section('content')
<div class="row align-items-center mt-5">
    <div class="col-md-6">
        <h1 class="display-4 fw-bold">Online Mentor–Student Collaboration Platform</h1>
        <p class="lead text-muted">Connect with industry experts, book 1-on-1 sessions, and achieve your career goals.</p>
        <div class="mt-4">
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">Get Started</a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">Login</a>
            @else
                <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
            @endguest
        </div>
    </div>
    <div class="col-md-6 text-center">
        <div class="rounded overflow-hidden shadow">
            <img src="{{ asset('images/mentor.jpg') }}" 
                alt="Mentor Image"
                class="img-fluid rounded"
                style="height: 300px; width: 100%; object-fit: cover;">
        </div>
    </div>
</div>
@endsection
