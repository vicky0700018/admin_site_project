@extends('app')

@section('title', 'Admin Dashboard')

@section('styles')
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-success: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        --gradient-warning: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        --gradient-danger: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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

    .stat-card.danger {
        border-left-color: #dc3545;
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

    .stat-card.warning .stat-icon {
        background: var(--gradient-warning);
    }

    .stat-card.danger .stat-icon {
        background: var(--gradient-danger);
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

    .activity-log {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        margin-top: 1.5rem;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #eee;
        transition: var(--animation);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item:hover {
        background: #f8f9fa;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.1rem;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    .activity-time {
        font-size: 0.85rem;
        color: #999;
        margin: 0.25rem 0 0 0;
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

    .status-rejected {
        background: #f8d7da;
        color: #721c24;
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
</style>
@endsection

@section('content')
<!-- Header -->
<div class="dashboard-header">
    <h1>
        <i class="fas fa-chart-line me-2"></i>Admin Dashboard
    </h1>
    <p>Welcome back, {{ auth()->user()->name }}. Here's what's happening with your platform today.</p>
</div>

<!-- Key Statistics -->
<div class="row">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <p class="stat-number">{{ $total_subadmins }}</p>
            <p class="stat-label">Active Subadmins</p>
        </div>
    </div>
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
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <p class="stat-number">{{ $leads_this_month }}</p>
            <p class="stat-label">Leads This Month</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <p class="stat-number">{{ $completed_leads }}</p>
            <p class="stat-label">Completed Leads</p>
        </div>
    </div>
</div>

<!-- Status Breakdown -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="stat-card">
            <h5 class="section-title">
                <i class="fas fa-chart-pie"></i>Leads by Status
            </h5>
            <div style="padding: 1rem 0;">
                @php
                    $statuses = ['new' => 'New', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'rejected' => 'Rejected'];
                @endphp
                @foreach($statuses as $key => $label)
                    @php
                        $count = $leads_by_status[$key] ?? 0;
                        $percentage = $total_leads > 0 ? ($count / $total_leads) * 100 : 0;
                    @endphp
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="font-weight: 600;">{{ $label }}</span>
                            <span class="status-badge status-{{ $key }}">{{ $count }}</span>
                        </div>
                        <div style="background: #e9ecef; height: 8px; border-radius: 4px; overflow: hidden;">
                            <div style="background: linear-gradient(90deg, #667eea, #764ba2); height: 100%; width: {{ $percentage }}%;" title="{{ number_format($percentage, 1) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="stat-card">
            <h5 class="section-title">
                <i class="fas fa-clock"></i>Weekly Overview
            </h5>
            <div style="padding: 1rem 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <div>
                        <p style="color: #666; margin: 0; font-size: 0.9rem;">This Week</p>
                        <p style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0 0;">{{ $leads_this_week }}</p>
                    </div>
                    <div style="text-align: right;">
                        <p style="color: #666; margin: 0; font-size: 0.9rem;">Conversion Rate</p>
                        <p style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0 0;">
                            {{ $total_leads > 0 ? round(($completed_leads / $total_leads) * 100, 1) : 0 }}%
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Leads & Activity -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="activity-log">
            <h5 class="section-title">
                <i class="fas fa-star"></i>Recent Leads
            </h5>
            @forelse($recent_leads as $lead)
                <div class="activity-item">
                    <div class="activity-icon" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                        {{ strtoupper(substr($lead->name, 0, 1)) }}
                    </div>
                    <div class="activity-content">
                        <p class="activity-title">{{ $lead->name }}</p>
                        <p class="activity-time">
                            <span class="status-badge status-{{ $lead->status }}">{{ $lead->status }}</span>
                            • {{ $lead->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: #999; padding: 1rem;">No leads yet</p>
            @endforelse
        </div>
    </div>

    <div class="col-md-6">
        <div class="activity-log">
            <h5 class="section-title">
                <i class="fas fa-history"></i>Recent Activity
            </h5>
            @forelse($recent_activity as $activity)
                <div class="activity-item">
                    <div class="activity-icon" style="background: #e9ecef;">
                        <i class="fas fa-{{ $activity->action === 'created' ? 'plus' : ($activity->action === 'deleted' ? 'trash' : 'edit') }}"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-title">
                            {{ $activity->user->name }}
                            <span style="color: #666; font-weight: normal;">
                                {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                {{ $activity->model_type }} #{{ $activity->model_id }}
                            </span>
                        </p>
                        <p class="activity-time">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: #999; padding: 1rem;">No activity yet</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="stat-card">
            <h5 class="section-title">
                <i class="fas fa-bolt"></i>Quick Actions
            </h5>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('admin.create.subadmin.form') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-2"></i>Create Subadmin
                </a>
                <a href="{{ route('admin.subadmins') }}" class="btn btn-info">
                    <i class="fas fa-users me-2"></i>Manage Subadmins
                </a>
                <a href="{{ route('subadmin.leads.index') }}" class="btn btn-success">
                    <i class="fas fa-list me-2"></i>View All Leads
                </a>
                <a href="{{ route('admin.activity-logs') }}" class="btn btn-warning">
                    <i class="fas fa-history me-2"></i>View Activity Logs
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
