@extends('app')

@section('content')
<div class="subadmin-container">
    <div class="header-row">
        <h2>SubAdmins</h2>
        <a href="{{ route('admin.create.subadmin.form') }}" class="btn-create">+ Create SubAdmin</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="styled-table">
        <thead>
    <tr>
        <th>#</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    @forelse($subadmins as $index => $subadmin)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $subadmin->name }}</td>
            <td>{{ $subadmin->email }}</td>
            <td>{{ $subadmin->created_at->format('d M Y') }}</td>
            <td>
                <a href="{{ route('admin.edit.subadmin', $subadmin->id) }}" class="btn-edit">Edit</a>

                <form action="{{ route('admin.delete.subadmin', $subadmin->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this SubAdmin?')">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" style="text-align:center;">No SubAdmins found</td>
        </tr>
    @endforelse
</tbody>

    </table>
</div>
@endsection

@section('styles')
<style>
.subadmin-container {
    background: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}
.btn-create {
    background: #2d89ef;
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
}
.btn-create:hover {
    background: #1d5fbf;
}
.styled-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}
.styled-table th, .styled-table td {
    padding: 0.8rem;
    border: 1px solid #ddd;
    text-align: left;
}
.styled-table th {
    background: #f4f6f8;
}
.alert {
    background: #d4edda;
    color: #155724;
    padding: 0.75rem;
    border-radius: 6px;
    margin-bottom: 1rem;
}

.btn-edit {
    background: #ffc107;
    color: #000;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
    margin-right: 5px;
}
.btn-edit:hover {
    background: #e0a800;
}
.btn-delete {
    background: #dc3545;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
}
.btn-delete:hover {
    background: #b02a37;
}
</style>
@endsection
