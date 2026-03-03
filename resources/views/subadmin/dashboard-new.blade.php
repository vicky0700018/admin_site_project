@extends('app')

@section('title', 'SubAdmin Dashboard')

@section('styles')
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-success: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        --card-shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
        --border-radius: 12px;
        --animation: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-header {
        background: var(--gradient-primary);
        color: white;
        padding: 2.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
    }

    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .dashboard-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        transition: var(--animation);
        border-left: 4px solid #667eea;
        margin-bottom: 1.5rem;
    }

    .stat-card:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-5px);
    }

    .stat-card.success {
        border-left-color: #28a745;
    }

    .stat-card.warning {
        border-left-color: #ffc107;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
    }

    .stat-card.primary .stat-icon {
        background: var(--gradient-primary);
    }

    .stat-card.success .stat-icon {
        background: var(--gradient-success);
    }

    .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #666;
        margin: 0.5rem 0 0 0;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 0.5rem;
        color: #667eea;
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-new {
        background: #cfe2ff;
        color: #084298;
    }

    .status-in_progress {
        background: #fff3cd;
        color: #856404;
    }

    .status-completed {
        background: #d1e7dd;
        color: #0f5132;
    }
</style>
@endsection

@section('content')
<!-- Header -->
<div class="dashboard-header">
    <h1>
        <i class="fas fa-tachometer-alt me-2"></i>SubAdmin Dashboard
    </h1>
    <p>Welcome, {{ auth()->user()->name }}. Here's your workspace.</p>
</div>

<!-- Key Statistics -->
<div class="row">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-user"></i>
            </div>
            <p class="stat-number">{{ $total_leads }}</p>
            <p class="stat-label">Total Leads</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <p class="stat-number">{{ $assigned_leads }}</p>
            <p class="stat-label">Assigned to Me</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <p class="stat-number">{{ $in_progress_leads }}</p>
            <p class="stat-label">In Progress</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <p class="stat-number">{{ $completed_leads }}</p>
            <p class="stat-label">Completed</p>
        </div>
    </div>
</div>

<!-- Status Breakdown -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="stat-card">
            <h5 class="section-title">
                <i class="fas fa-chart-bar"></i>My Leads by Status
            </h5>
            <div style="padding: 1rem 0;">
                @php
                    $statuses = ['new' => 'New', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'rejected' => 'Rejected'];
                    $total = $assigned_leads;
                @endphp
                @foreach($statuses as $key => $label)
                    @php
                        $count = $leads_by_status[$key] ?? 0;
                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                    @endphp
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="font-weight: 600;">{{ $label }}</span>
                            <span class="status-badge status-{{ $key }}">{{ $count }}</span>
                        </div>
                        <div style="background: #e9ecef; height: 8px; border-radius: 4px; overflow: hidden;">
                            <div style="background: linear-gradient(90deg, #667eea, #764ba2); height: 100%; width: {{ $percentage }}%;">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="stat-card">
            <h5 class="section-title">
                <i class="fas fa-trendingup"></i>Performance
            </h5>
            <div style="padding: 1rem 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem;">
                    <div>
                        <p style="color: #666; margin: 0; font-size: 0.9rem;">Completion Rate</p>
                        <p style="font-size: 1.75rem; font-weight: 700; margin: 0.5rem 0 0 0;">
                            {{ $assigned_leads > 0 ? round(($completed_leads / $assigned_leads) * 100, 1) : 0 }}%
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Leads -->
<div class="row mt-4">
    <div class="col-12">
        <div class="stat-card">
            <h5 class="section-title">
                <i class="fas fa-list"></i>My Recent Leads
            </h5>
            @if($recent_leads->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table table-hover" style="margin: 0;">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_leads as $lead)
                                <tr>
                                    <td><strong>{{ $lead->name }}</strong></td>
                                    <td>{{ $lead->email }}</td>
                                    <td>{{ $lead->mobile }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $lead->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $lead->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('subadmin.leads.show', $lead->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('subadmin.leads.edit', $lead->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">No leads assigned to you yet</p>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="stat-card">
            <h5 class="section-title">
                <i class="fas fa-lightning-bolt"></i>Quick Actions
            </h5>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('subadmin.leads.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Create New Lead
                </a>
                <a href="{{ route('subadmin.leads.index') }}" class="btn btn-primary">
                    <i class="fas fa-list me-2"></i>View All Leads
                </a>
                <a href="{{ route('subadmin.leads.documents.index') }}" class="btn btn-info">
                    <i class="fas fa-file me-2"></i>View Documents
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
