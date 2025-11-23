@extends('app') {{-- assuming your template is layouts/admin.blade.php --}}

@section('content')
<div class="form-container">
    <h2>Create SubAdmin</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('create.subadmin') }}" method="POST" class="styled-form">
        @csrf
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" placeholder="Enter full name" value="{{ old('name') }}" required>
            @error('name') <small class="error">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}" required>
            @error('email') <small class="error">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter password" required>
            @error('password') <small class="error">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn-submit">Create SubAdmin</button>
    </form>
</div>
@endsection

@section('styles')
<style>
    .form-container {
        background: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        max-width: 500px;
        margin: auto;
    }
    .form-container h2 {
        margin-bottom: 1rem;
        color: #333;
    }
    .form-group {
        margin-bottom: 1.2rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #444;
    }
    .form-group input {
        width: 100%;
        padding: 0.7rem;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    .btn-submit {
        background: #2d89ef;
        color: #fff;
        padding: 0.7rem 1.5rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }
    .btn-submit:hover {
        background: #1d5fbf;
    }
    .alert {
        background: #d4edda;
        color: #155724;
        padding: 0.75rem;
        border-radius: 6px;
        margin-bottom: 1rem;
    }
    .error {
        color: red;
        font-size: 0.85rem;
    }
</style>
@endsection
