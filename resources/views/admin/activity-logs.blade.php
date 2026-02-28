@extends('app')

@section('title', 'Activity Logs')

@section('styles')
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        --card-shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
        --border-radius: 12px;
        --animation: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-header {
        background: var(--gradient-primary);
        color: white;
        padding: 2.5rem 0;
        margin: -1.5rem -1.5rem 2rem -1.5rem;
        border-radius: 0 0 20px 20px;
        box-shadow: var(--card-shadow);
    }

    .page-title {
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0;
    }

    .filter-card {
        background: white;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
    }

    .log-item {
        padding: 1.25rem;
        border-left: 4px solid #667eea;
        background: white;
        border-radius: var(--border-radius);
        margin-bottom: 1rem;
        box-shadow: var(--card-shadow);
        transition: var(--animation);
    }

    .log-item:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateX(5px);
    }

    .log-action {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-right: 0.5rem;
    }

    .log-action.created {
        background: #d4edda;
        color: #155724;
    }

    .log-action.updated {
        background: #fff3cd;
        color: #856404;
    }

    .log-action.deleted {
        background: #f8d7da;
        color: #721c24;
    }

    .log-action.status_changed {
        background: #cfe2ff;
        color: #084298;
    }

    .log-action.assigned {
        background: #e7d4f5;
        color: #664ba2;
    }

    .log-meta {
        display: flex;
        gap: 2rem;
        margin-top: 0.75rem;
        font-size: 0.9rem;
        color: #666;
    }

    .log-meta i {
        margin-right: 0.5rem;
        color: #667eea;
    }

    .log-values {
        margin-top: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .log-values strong {
        color: #667eea;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="page-title">
            <i class="fas fa-history me-2"></i>Activity Logs
        </h1>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-card">
    <form method="GET" action="{{ route('admin.activity-logs') }}" class="row g-3">
        <div class="col-md-3">
            <select name="user_id" class="form-select">
                <option value="">All Users</option>
                @foreach($logs->pluck('user')->unique('id') as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="action" class="form-select">
                <option value="">All Actions</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $action)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="model_type" class="form-select">
                <option value="">All Models</option>
                @foreach($modelTypes as $type)
                    <option value="{{ $type }}" {{ request('model_type') === $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
    </form>
</div>

<!-- Activity Logs -->
<div>
    @forelse($logs as $log)
        <div class="log-item">
            <div>
                <span class="log-action {{ $log->action }}">
                    <i class="fas fa-{{ $log->action === 'created' ? 'plus' : ($log->action === 'deleted' ? 'trash' : 'edit') }} me-1"></i>
                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                </span>
                <strong>{{ $log->model_type }}</strong> #{{ $log->model_id }}
            </div>
            <div class="log-meta">
                <div>
                    <i class="fas fa-user"></i>
                    By: <strong>{{ $log->user->name }}</strong>
                </div>
                <div>
                    <i class="fas fa-calendar"></i>
                    {{ $log->created_at->format('M d, Y H:i') }}
                </div>
            </div>

            @if($log->description)
                <div style="margin-top: 0.75rem; font-style: italic; color: #555;">
                    {{ $log->description }}
                </div>
            @endif

            @if($log->new_values)
                <div class="log-values">
                    <strong>Changes:</strong>
                    @foreach($log->new_values as $key => $value)
                        <div>
                            <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                            @if($log->old_values && isset($log->old_values[$key]))
                                <span style="text-decoration: line-through; color: #999;">
                                    {{ is_array($log->old_values[$key]) ? json_encode($log->old_values[$key]) : $log->old_values[$key] }}
                                </span>
                                →
                            @endif
                            <strong style="color: #28a745;">
                                {{ is_array($value) ? json_encode($value) : $value }}
                            </strong>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <div style="text-align: center; padding: 3rem; background: white; border-radius: 12px;">
            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
            <h4>No Activity Logs Found</h4>
            <p>No activities match your filter criteria.</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($logs->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $logs->links() }}
    </div>
@endif
@endsection
