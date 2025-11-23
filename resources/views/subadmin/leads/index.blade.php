@extends('app')

@section('title', 'Leads Management')

@section('styles')
<style>
    /* Enhanced Variables */
    :root {
        --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        --gradient-success: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        --gradient-warning: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        --gradient-danger: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        --gradient-info: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        --card-shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
        --border-radius: 12px;
        --animation: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Page Header */
    .page-header {
        background: var(--gradient-primary);
        color: white;
        padding: 2.5rem 0;
        margin: -1.5rem -1.5rem 2rem -1.5rem;
        border-radius: 0 0 20px 20px;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        opacity: 0.3;
    }

    .page-header .container {
        position: relative;
        z-index: 1;
    }

    .page-title {
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-subtitle {
        opacity: 0.9;
        margin-top: 0.5rem;
        font-size: 1.1rem;
    }

    /* Header Actions */
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: white;
        padding: 1.5rem 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
    }

    .stats-cards {
        display: flex;
        gap: 1rem;
    }

    .stat-card {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        text-align: center;
        min-width: 120px;
        transition: var(--animation);
        border-left: 4px solid var(--primary);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-shadow-hover);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        display: block;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #666;
        margin-top: 0.25rem;
    }

    /* Enhanced Buttons */
    .btn-create {
        background: var(--gradient-success);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--animation);
        position: relative;
        overflow: hidden;
    }

    .btn-create::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-create:hover::before {
        left: 100%;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
    }

    /* Enhanced Table */
    .table-wrapper {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: var(--animation);
    }

    .table-wrapper:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .table-header {
        background: var(--gradient-primary);
        color: white;
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }

    .table-count {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
    }

    .custom-table {
        margin: 0;
        background: white;
    }

    .custom-table thead th {
        background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
        color: white;
        border: none;
        padding: 1.25rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
    }

    .custom-table thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--primary);
    }

    .custom-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f4;
        transition: var(--animation);
    }

    .custom-table tbody tr {
        transition: var(--animation);
    }

    .custom-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.02) 0%, rgba(63, 55, 201, 0.02) 100%);
        transform: translateY(-1px);
    }

    /* Enhanced Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        font-size: 0.85rem;
        transition: var(--animation);
        position: relative;
        overflow: hidden;
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        transform: translate(-50%, -50%);
    }

    .btn-action:hover::before {
        width: 100px;
        height: 100px;
    }

    .btn-action:hover {
        transform: translateY(-2px) scale(1.05);
    }

    .btn-edit {
        background: var(--gradient-warning);
        color: white;
    }

    .btn-edit:hover {
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        color: white;
    }

    .btn-delete {
        background: var(--gradient-danger);
        color: white;
    }

    .btn-delete:hover {
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        color: white;
    }

    .btn-view {
        background: var(--gradient-info);
        color: white;
    }

    .btn-view:hover {
        box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
        color: white;
    }

    .btn-upload {
        background: linear-gradient(135deg, #6f42c1 0%, #563d7c 100%);
        color: white;
    }

    .btn-upload:hover {
        box-shadow: 0 6px 20px rgba(111, 66, 193, 0.4);
        color: white;
    }

    /* Enhanced Badges */
    .lead-id {
        background: var(--gradient-primary);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
    }

    .gender-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .gender-male {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
    }

    .gender-female {
        background: linear-gradient(135deg, #e91e63 0%, #c2185b 100%);
        color: white;
    }

    .gender-other {
        background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
        color: white;
    }

    /* Enhanced Alerts */
    .alert-enhanced {
        border: none;
        border-radius: var(--border-radius);
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        background: var(--gradient-success);
        color: white;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .alert-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: rgba(255, 255, 255, 0.5);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        color: #dee2e6;
        display: block;
    }

    .empty-state h4 {
        color: #495057;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .empty-state p {
        color: #6c757d;
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .header-actions {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .stats-cards {
            justify-content: center;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 2rem 0;
            margin: -1rem -1rem 1.5rem -1rem;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn-action {
            width: 100%;
            height: auto;
            padding: 0.5rem;
            border-radius: 6px;
        }

        .custom-table thead th {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }

        .custom-table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
       

<!-- Header Actions -->
<div class="header-actions">
    <div class="stats-cards">
        <div class="stat-card">
            <span class="stat-number">{{ $leads->total() ?? $leads->count() }}</span>
            <span class="stat-label">Total Leads</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $leads->where('created_at', '>=', now()->startOfMonth())->count() }}</span>
            <span class="stat-label">This Month</span>
        </div>
    </div>
    
    <a href="{{ route('subadmin.leads.create') }}" class="btn-create">
        <i class="fas fa-plus-circle me-2"></i> Create New Lead
    </a>
</div>

<!-- Success Alert -->
@if(session('success'))
    <div class="alert-enhanced alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Table Wrapper -->
<div class="table-wrapper">
    <div class="table-header">
        <h3 class="table-title">
            <i class="fas fa-list me-2"></i> All Leads
        </h3>
        <span class="table-count">
            {{ $leads->total() ?? $leads->count() }} leads
        </span>
    </div>
    
    <div class="table-responsive">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                    <tr>
                        
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2" style="width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                    {{ strtoupper(substr($lead->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $lead->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-envelope text-muted me-2"></i>
                            {{ $lead->email }}
                        </td>
                        <td>
                            <i class="fas fa-phone text-muted me-2"></i>
                            {{ $lead->mobile }}
                        </td>
                        <td>
                            @if($lead->dob)
                                <i class="fas fa-calendar text-muted me-2"></i>
                                {{ \Carbon\Carbon::parse($lead->dob)->format('M d, Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($lead->gender)
                                <span class="gender-badge gender-{{ $lead->gender }}">
                                    <i class="{{ $lead->gender === 'male' ? 'mars' : ($lead->gender === 'female' ? 'venus' : 'venus-mars') }} me-1"></i>
                                    {{ ucfirst($lead->gender) }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <i class="fas fa-clock text-muted me-2"></i>
                            {{ $lead->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- Edit Lead -->
                                <a href="{{ route('subadmin.leads.edit', $lead->id) }}" 
                                   class="btn-action btn-edit" title="Edit Lead">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Lead -->
                                <form action="{{ route('subadmin.leads.destroy', $lead->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this lead?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Delete Lead">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                                <!-- Upload or View Document -->
                                @if($lead->documents && $lead->documents->count() > 0)
                                    <a href="{{ route('subadmin.leads.documents.show', $lead->id) }}" 
                                       class="btn-action btn-view" title="View Documents">
                                        <i class="fas fa-folder-open"></i>
                                    </a>
                                @else
                                    <a href="{{ route('subadmin.leads.documents.create', $lead->id) }}" 
                                       class="btn-action btn-upload" title="Upload Document">
                                        <i class="fas fa-upload"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-users empty-state-icon"></i>
                                <h4>No Leads Found</h4>
                                <p>Get started by creating your first lead to begin managing your contacts</p>
                                <a href="{{ route('subadmin.leads.create') }}" class="btn-create">
                                    <i class="fas fa-plus me-2"></i>Create Your First Lead
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if(method_exists($leads, 'links'))
    <div class="d-flex justify-content-center mt-4">
        {{ $leads->links() }}
    </div>
@endif
@endsection