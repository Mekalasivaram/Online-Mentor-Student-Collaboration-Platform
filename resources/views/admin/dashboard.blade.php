@extends('layouts.app')
@section('content')
<h2>Admin Dashboard</h2>
<div class="row mt-4">
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white p-3">
            <h4>Total Users</h4>
            <h2>{{ $users->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white p-3">
            <h4>Total Mentors</h4>
            <h2>{{ $users->where('role', 'mentor')->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-info text-white p-3">
            <h4>Total Sessions</h4>
            <h2>{{ $bookings->count() }}</h2>
        </div>
    </div>
</div>

<h4 class="mt-4">Users List</h4>
<div class="card p-3">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst($user->role) }}</span></td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
