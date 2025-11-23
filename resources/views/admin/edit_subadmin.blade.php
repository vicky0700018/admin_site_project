@extends('app')

@section('content')
<div class="edit-subadmin-container">
    <h2>Edit SubAdmin</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.update.subadmin', $subadmin->id) }}" method="POST" class="edit-form">
        @csrf
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $subadmin->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $subadmin->email) }}" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Update</button>
            <a href="{{ route('admin.subadmins') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
.edit-subadmin-container {
    background: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    max-width: 600px;
    margin: 2rem auto;
}
.edit-subadmin-container h2 {
    margin-bottom: 1rem;
}
.form-group {
    margin-bottom: 1rem;
}
.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 0.5rem;
}
.form-group input {
    width: 100%;
    padding: 0.6rem;
    border: 1px solid #ccc;
    border-radius: 6px;
}
.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 1rem;
}
.btn-save {
    background: #28a745;
    color: #fff;
    padding: 0.6rem 1.2rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.btn-save:hover {
    background: #218838;
}
.btn-cancel {
    background: #6c757d;
    color: #fff;
    padding: 0.6rem 1.2rem;
    border-radius: 6px;
    text-decoration: none;
}
.btn-cancel:hover {
    background: #5a6268;
}
.alert {
    background: #f8d7da;
    color: #721c24;
    padding: 0.75rem;
    border-radius: 6px;
    margin-bottom: 1rem;
}
</style>
@endsection
