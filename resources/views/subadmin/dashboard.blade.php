@extends('app')

@section('title', 'SubAdmin Dashboard')

@section('content')
    <div class="dashboard-header">
        <h1>SubAdmin Dashboard</h1>
        <p>Welcome, {{ auth()->user()->name }}. Here’s your workspace.</p>
    </div>
@endsection
