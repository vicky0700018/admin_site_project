@extends('app')

@section('styles')
<style>
    .documents-container {
        max-width: 100%;
        margin: 0 auto;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-header h2 {
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-header .header-icon {
        font-size: 2rem;
        opacity: 0.9;
    }

    .stats-info {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        opacity: 0.9;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: bold;
        line-height: 1;
    }

    .stats-label {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .alert {
        padding: 1.5rem 2rem;
        border-radius: 10px;
        border: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .alert-warning {
        background: linear-gradient(135deg, #ffc107, #ff8f00);
        color: white;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }

    .alert i {
        font-size: 1.5rem;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .table-header {
        background: linear-gradient(135deg, var(--dark), #2a2d3a);
        padding: 1.5rem 2rem;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-header h4 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .table-responsive {
        border-radius: 0;
    }

    .documents-table {
        margin: 0;
        border: none;
    }

    .documents-table thead {
        background: linear-gradient(135deg, #343a46, #2a2d3a);
    }

    .documents-table thead th {
        background: transparent;
        border: none;
        color: white;
        font-weight: 600;
        padding: 1.25rem 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    .documents-table tbody tr {
        transition: var(--transition);
        border-bottom: 1px solid #f1f3f4;
    }

    .documents-table tbody tr:hover {
        background: rgba(67, 97, 238, 0.02);
        transform: scale(1.001);
    }

    .documents-table tbody tr:last-child {
        border-bottom: none;
    }

    .documents-table td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border: none;
        font-size: 0.95rem;
    }

    .lead-info {
        display: flex;
        flex-direction: column;
    }

    .lead-name {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .lead-details {
        font-size: 0.85rem;
        color: var(--gray);
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--dark);
    }

    .contact-item i {
        font-size: 0.8rem;
        color: var(--primary);
        width: 12px;
    }

    .document-status {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 40px;
    }

    .btn-view {
        background: linear-gradient(135deg, var(--success), #3a86ff);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(76, 201, 240, 0.3);
    }

    .btn-view:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(76, 201, 240, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-view i {
        font-size: 0.8rem;
    }

    .not-uploaded {
        color: var(--gray);
        font-style: italic;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: center;
    }

    .not-uploaded i {
        color: #dc3545;
        font-size: 0.8rem;
    }

    .document-grid {
        display: none;
    }

    /* Mobile Responsive Cards */
    @media (max-width: 1200px) {
        .table-responsive {
            overflow-x: auto;
        }
        
        .documents-table {
            min-width: 1000px;
        }
    }

    @media (max-width: 768px) {
        .documents-container {
            margin: 0;
        }

        .page-header {
            padding: 1.5rem;
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .page-header h2 {
            font-size: 1.5rem;
        }

        .stats-info {
            align-items: center;
        }

        .table-container {
            display: none;
        }

        .document-grid {
            display: block;
        }

        .lead-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-left: 4px solid var(--primary);
        }

        .lead-card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f3f4;
        }

        .lead-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
        }

        .doc-item {
            text-align: center;
            padding: 1rem 0.5rem;
            background: #f8f9fa;
            border-radius: 8px;
            transition: var(--transition);
        }

        .doc-item:hover {
            background: rgba(67, 97, 238, 0.05);
        }

        .doc-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="documents-container">
    <div class="page-header">
        <h2>
            <i class="fas fa-folder-open header-icon"></i>
            All Leads Documents
        </h2>
        @if(!$leads->isEmpty())
            <div class="stats-info">
                <div class="stats-number">{{ $leads->count() }}</div>
                <div class="stats-label">Total Leads</div>
            </div>
        @endif
    </div>

    @if($leads->isEmpty())
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>No Data Found</strong><br>
                <small>No leads or documents are available at the moment.</small>
            </div>
        </div>
    @else
        <!-- Desktop Table View -->
        <div class="table-container">
            <div class="table-header">
                <h4>
                    <i class="fas fa-table"></i>
                    Documents Overview
                </h4>
            </div>
            
            <div class="table-responsive">
                <table class="table documents-table">
                    <thead>
                        <tr>
                            <th>Lead Information</th>
                            <th>Contact Details</th>
                            <th>Aadhaar Front</th>
                            <th>Aadhaar Back</th>
                            <th>PAN Front</th>
                            <th>PAN Back</th>
                            <th>Other Docs</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leads as $lead)
                            <tr>
                                <td>
                                    <div class="lead-info">
                                        <div class="lead-name">{{ $lead->name }}</div>
                                        <div class="lead-details">ID: #{{ $lead->id }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="contact-info">
                                        
                                        <div class="contact-item">
                                            <i class="fas fa-phone"></i>
                                            <span>{{ $lead->mobile }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Aadhaar Front --}}
                                <td>
                                    <div class="document-status">
                                        @if($lead->documents && $lead->documents->aadhaar_front)
                                            <a href="{{ asset('storage/'.$lead->documents->aadhaar_front) }}" target="_blank" class="btn-view">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                        @else
                                            <span class="not-uploaded">
                                                <i class="fas fa-times-circle"></i>
                                                Not Uploaded
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Aadhaar Back --}}
                                <td>
                                    <div class="document-status">
                                        @if($lead->documents && $lead->documents->aadhaar_back)
                                            <a href="{{ asset('storage/'.$lead->documents->aadhaar_back) }}" target="_blank" class="btn-view">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                        @else
                                            <span class="not-uploaded">
                                                <i class="fas fa-times-circle"></i>
                                                Not Uploaded
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- PAN Front --}}
                                <td>
                                    <div class="document-status">
                                        @if($lead->documents && $lead->documents->pan_front)
                                            <a href="{{ asset('storage/'.$lead->documents->pan_front) }}" target="_blank" class="btn-view">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                        @else
                                            <span class="not-uploaded">
                                                <i class="fas fa-times-circle"></i>
                                                Not Uploaded
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- PAN Back --}}
                                <td>
                                    <div class="document-status">
                                        @if($lead->documents && $lead->documents->pan_back)
                                            <a href="{{ asset('storage/'.$lead->documents->pan_back) }}" target="_blank" class="btn-view">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                        @else
                                            <span class="not-uploaded">
                                                <i class="fas fa-times-circle"></i>
                                                Not Uploaded
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Other Docs --}}
                                <td>
                                    <div class="document-status">
                                        @if($lead->documents && $lead->documents->other_docs)
                                            <a href="{{ asset('storage/'.$lead->documents->other_docs) }}" target="_blank" class="btn-view">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                        @else
                                            <span class="not-uploaded">
                                                <i class="fas fa-times-circle"></i>
                                                Not Uploaded
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="document-grid">
            @foreach($leads as $lead)
                <div class="lead-card">
                    <div class="lead-card-header">
                        <div class="lead-avatar">{{ substr($lead->name, 0, 1) }}</div>
                        <div class="lead-info">
                            <div class="lead-name">{{ $lead->name }}</div>
                            <div class="contact-info">
                                
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <span>{{ $lead->mobile }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="documents-grid">
                        <div class="doc-item">
                            <div class="doc-label">Aadhaar Front</div>
                            @if($lead->documents && $lead->documents->aadhaar_front)
                                <a href="{{ asset('storage/'.$lead->documents->aadhaar_front) }}" target="_blank" class="btn-view">
                                    <i class="fas fa-eye"></i>
                                    View
                                </a>
                            @else
                                <span class="not-uploaded">
                                    <i class="fas fa-times-circle"></i>
                                    Not Available
                                </span>
                            @endif
                        </div>

                        <div class="doc-item">
                            <div class="doc-label">Aadhaar Back</div>
                            @if($lead->documents && $lead->documents->aadhaar_back)
                                <a href="{{ asset('storage/'.$lead->documents->aadhaar_back) }}" target="_blank" class="btn-view">
                                    <i class="fas fa-eye"></i>
                                    View
                                </a>
                            @else
                                <span class="not-uploaded">
                                    <i class="fas fa-times-circle"></i>
                                    Not Available
                                </span>
                            @endif
                        </div>

                        <div class="doc-item">
                            <div class="doc-label">PAN Front</div>
                            @if($lead->documents && $lead->documents->pan_front)
                                <a href="{{ asset('storage/'.$lead->documents->pan_front) }}" target="_blank" class="btn-view">
                                    <i class="fas fa-eye"></i>
                                    View
                                </a>
                            @else
                                <span class="not-uploaded">
                                    <i class="fas fa-times-circle"></i>
                                    Not Available
                                </span>
                            @endif
                        </div>

                        <div class="doc-item">
                            <div class="doc-label">PAN Back</div>
                            @if($lead->documents && $lead->documents->pan_back)
                                <a href="{{ asset('storage/'.$lead->documents->pan_back) }}" target="_blank" class="btn-view">
                                    <i class="fas fa-eye"></i>
                                    View
                                </a>
                            @else
                                <span class="not-uploaded">
                                    <i class="fas fa-times-circle"></i>
                                    Not Available
                                </span>
                            @endif
                        </div>

                        <div class="doc-item">
                            <div class="doc-label">Other Docs</div>
                            @if($lead->documents && $lead->documents->other_docs)
                                <a href="{{ asset('storage/'.$lead->documents->other_docs) }}" target="_blank" class="btn-view">
                                    <i class="fas fa-eye"></i>
                                    View
                                </a>
                            @else
                                <span class="not-uploaded">
                                    <i class="fas fa-times-circle"></i>
                                    Not Available
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection