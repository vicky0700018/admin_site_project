@extends('app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}. Here's what's happening with your platform today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="card-grid">
        <div class="card">
            <div class="card-icon blue">
                <i class="fas fa-users"></i>
            </div>

        </div>
        <!-- More cards... -->
    </div>

@endsection