@extends('app')

@section('styles')
<style>
    .documents-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: rotate(45deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .page-header h2 {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon {
        font-size: 2rem;
        opacity: 0.9;
    }

    .lead-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .lead-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.5rem;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }

    .lead-details h3 {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .lead-meta {
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .documents-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .section-header {
        background: linear-gradient(135deg, var(--dark), #2a2d3a);
        color: white;
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .section-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .documents-grid {
        padding: 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .document-card {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1.5rem;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .document-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    .document-card.has-document {
        background: linear-gradient(135deg, rgba(76, 201, 240, 0.05), rgba(67, 97, 238, 0.05));
        border-color: var(--success);
    }

    .document-card.no-document {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.02), rgba(255, 193, 7, 0.02));
        border-color: #ffc107;
        border-style: dashed;
    }

    .document-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .document-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .document-icon.aadhaar {
        background: linear-gradient(135deg, #4cc9f0, #3a86ff);
    }

    .document-icon.pan {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
    }

    .document-icon.other {
        background: linear-gradient(135deg, #a8e6cf, #26c485);
    }

    .document-title {
        font-weight: 600;
        color: var(--dark);
        font-size: 1.1rem;
        margin: 0;
    }

    .document-status {
        margin-top: 1rem;
    }

    .btn-view {
        background: linear-gradient(135deg, var(--success), #3a86ff);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.95rem;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 4px 15px rgba(76, 201, 240, 0.3);
        width: 100%;
        justify-content: center;
    }

    .btn-view:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(76, 201, 240, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-view i {
        font-size: 1rem;
    }

    .no-document-status {
        text-align: center;
        color: #6c757d;
        font-style: italic;
        padding: 1rem;
        background: rgba(108, 117, 125, 0.1);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .no-document-status i {
        color: #dc3545;
        font-size: 1.2rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--gray);
    }

    .empty-state i {
        font-size: 4rem;
        color: #e9ecef;
        margin-bottom: 1rem;
    }

    .empty-state h4 {
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        margin: 0;
        opacity: 0.8;
    }

    .back-button {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .back-button:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateX(-2px);
    }

    @media (max-width: 768px) {
        .documents-container {
            margin: 0;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-header h2 {
            font-size: 1.5rem;
        }

        .lead-info {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .lead-avatar {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }

        .documents-grid {
            padding: 1.5rem;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .section-header {
            padding: 1rem 1.5rem;
        }

        .document-card {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="documents-container">
    <div class="page-header">
        <div class="header-content">
            <a href="javascript:history.back()" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
            
            <h2>
                <i class="fas fa-folder-open header-icon"></i>
                Document Portfolio
            </h2>
            
            <div class="lead-info">
                <div class="lead-avatar">{{ substr($lead->name, 0, 1) }}</div>
                <div class="lead-details">
                    <h3>{{ $lead->name }}</h3>
                    <div class="lead-meta">Lead ID: #{{ $lead->id }} • Documents Overview</div>
                </div>
            </div>
        </div>
    </div>

    <div class="documents-section">
        <div class="section-header">
            <i class="fas fa-file-alt"></i>
            <h4>Uploaded Documents</h4>
        </div>

        @if($lead->documents)
            <div class="documents-grid">
                @if($lead->documents->aadhaar_front)
                    <div class="document-card has-document">
                        <div class="document-header">
                            <div class="document-icon aadhaar">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <h5 class="document-title">Aadhaar Card - Front</h5>
                        </div>
                        <div class="document-status">
                            <a href="{{ asset('storage/' . $lead->documents->aadhaar_front) }}" target="_blank" class="btn-view">
                                <i class="fas fa-external-link-alt"></i>
                                View Document
                            </a>
                        </div>
                    </div>
                @else
                    <div class="document-card no-document">
                        <div class="document-header">
                            <div class="document-icon aadhaar">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <h5 class="document-title">Aadhaar Card - Front</h5>
                        </div>
                        <div class="document-status">
                            <div class="no-document-status">
                                <i class="fas fa-times-circle"></i>
                                Not uploaded yet
                            </div>
                        </div>
                    </div>
                @endif

                @if($lead->documents->aadhaar_back)
                    <div class="document-card has-document">
                        <div class="document-header">
                            <div class="document-icon aadhaar">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <h5 class="document-title">Aadhaar Card - Back</h5>
                        </div>
                        <div class="document-status">
                            <a href="{{ asset('storage/' . $lead->documents->aadhaar_back) }}" target="_blank" class="btn-view">
                                <i class="fas fa-external-link-alt"></i>
                                View Document
                            </a>
                        </div>
                    </div>
                @else
                    <div class="document-card no-document">
                        <div class="document-header">
                            <div class="document-icon aadhaar">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <h5 class="document-title">Aadhaar Card - Back</h5>
                        </div>
                        <div class="document-status">
                            <div class="no-document-status">
                                <i class="fas fa-times-circle"></i>
                                Not uploaded yet
                            </div>
                        </div>
                    </div>
                @endif

                @if($lead->documents->pan_front)
                    <div class="document-card has-document">
                        <div class="document-header">
                            <div class="document-icon pan">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h5 class="document-title">PAN Card - Front</h5>
                        </div>
                        <div class="document-status">
                            <a href="{{ asset('storage/' . $lead->documents->pan_front) }}" target="_blank" class="btn-view">
                                <i class="fas fa-external-link-alt"></i>
                                View Document
                            </a>
                        </div>
                    </div>
                @else
                    <div class="document-card no-document">
                        <div class="document-header">
                            <div class="document-icon pan">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h5 class="document-title">PAN Card - Front</h5>
                        </div>
                        <div class="document-status">
                            <div class="no-document-status">
                                <i class="fas fa-times-circle"></i>
                                Not uploaded yet
                            </div>
                        </div>
                    </div>
                @endif

                @if($lead->documents->pan_back)
                    <div class="document-card has-document">
                        <div class="document-header">
                            <div class="document-icon pan">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h5 class="document-title">PAN Card - Back</h5>
                        </div>
                        <div class="document-status">
                            <a href="{{ asset('storage/' . $lead->documents->pan_back) }}" target="_blank" class="btn-view">
                                <i class="fas fa-external-link-alt"></i>
                                View Document
                            </a>
                        </div>
                    </div>
                @else
                    <div class="document-card no-document">
                        <div class="document-header">
                            <div class="document-icon pan">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h5 class="document-title">PAN Card - Back</h5>
                        </div>
                        <div class="document-status">
                            <div class="no-document-status">
                                <i class="fas fa-times-circle"></i>
                                Not uploaded yet
                            </div>
                        </div>
                    </div>
                @endif

                @if($lead->documents->other_docs)
                    <div class="document-card has-document">
                        <div class="document-header">
                            <div class="document-icon other">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h5 class="document-title">Other Documents</h5>
                        </div>
                        <div class="document-status">
                            <a href="{{ asset('storage/' . $lead->documents->other_docs) }}" target="_blank" class="btn-view">
                                <i class="fas fa-external-link-alt"></i>
                                View Document
                            </a>
                        </div>
                    </div>
                @else
                    <div class="document-card no-document">
                        <div class="document-header">
                            <div class="document-icon other">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h5 class="document-title">Other Documents</h5>
                        </div>
                        <div class="document-status">
                            <div class="no-document-status">
                                <i class="fas fa-times-circle"></i>
                                Not uploaded yet
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <h4>No Documents Found</h4>
                <p>No documents have been uploaded for this lead yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection