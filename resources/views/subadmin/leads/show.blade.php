@extends('app') {{-- Or your main layout file --}}

@section('title', 'Lead Details')

@section('content')
<div class="container">
    <div class="card shadow-lg rounded-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Lead Details</h4>
            <a href="{{ route('subadmin.leads.index') }}" class="btn btn-light btn-sm">← Back to Leads</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Name</th>
                    <td>{{ $lead->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $lead->email }}</td>
                </tr>
                <tr>
                    <th>Mobile</th>
                    <td>{{ $lead->mobile }}</td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td>{{ $lead->dob ? \Carbon\Carbon::parse($lead->dob)->format('d M, Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ ucfirst($lead->gender) ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $lead->created_at->format('d M, Y H:i A') }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $lead->updated_at->format('d M, Y H:i A') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('subadmin.leads.edit', $lead->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection
