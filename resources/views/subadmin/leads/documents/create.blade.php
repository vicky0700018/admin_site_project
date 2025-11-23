@extends('app')

@section('styles')
<style>
    .upload-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3);
    }

    .page-header h2 {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .page-header .lead-info {
        font-size: 1rem;
        opacity: 0.9;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        border: none;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #4cc9f0, #4cc9f0);
        color: white;
        box-shadow: 0 4px 15px rgba(76, 201, 240, 0.3);
    }

    .upload-form {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #dee2e6;
    }

    .form-header h4 {
        color: var(--dark);
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .form-header i {
        margin-right: 0.75rem;
        color: var(--primary);
    }

    .form-body {
        padding: 2rem;
    }

    .document-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .document-item {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        padding: 1.5rem;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .document-item:hover {
        border-color: var(--primary);
        background: rgba(67, 97, 238, 0.02);
    }

    .document-item.has-file {
        border-color: var(--success);
        background: rgba(76, 201, 240, 0.1);
        border-style: solid;
    }

    .document-label {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .document-label i {
        margin-right: 0.75rem;
        font-size: 1.2rem;
        color: var(--primary);
        width: 20px;
        text-align: center;
    }

    .file-input-wrapper {
        position: relative;
        cursor: pointer;
    }

    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-input-display {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 1rem;
        border: 2px dashed #ccc;
        border-radius: 8px;
        transition: var(--transition);
        background: white;
        min-height: 80px;
    }

    .file-input-display:hover {
        border-color: var(--primary);
        background: rgba(67, 97, 238, 0.02);
    }

    .file-input-content {
        text-align: center;
        color: var(--gray);
    }

    .file-input-content i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        display: block;
        color: var(--primary);
    }

    .file-input-content .upload-text {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .file-input-content .file-info {
        font-size: 0.85rem;
        opacity: 0.8;
    }

    .file-selected {
        border-color: var(--success) !important;
        background: rgba(76, 201, 240, 0.1) !important;
    }

    .file-selected .file-input-content {
        color: var(--success);
    }

    .file-name {
        font-weight: 600;
        color: var(--dark);
        margin-top: 0.5rem;
        padding: 0.5rem;
        background: white;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        font-size: 0.9rem;
        display: none;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0 auto;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(67, 97, 238, 0.4);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .upload-container {
            margin: 0;
        }
        
        .page-header {
            padding: 1.5rem;
        }
        
        .form-body {
            padding: 1.5rem;
        }
        
        .document-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .document-item {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="upload-container">
    <div class="page-header">
        <h2>Upload Documents</h2>
        <div class="lead-info">
            <i class="fas fa-user-circle"></i>
            For: {{ $lead->name }}
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('subadmin.leads.documents.store', $lead->id) }}" method="POST" enctype="multipart/form-data" class="upload-form">
        @csrf

        <div class="form-header">
            <h4>
                <i class="fas fa-cloud-upload-alt"></i>
                Document Upload
            </h4>
        </div>

        <div class="form-body">
            <div class="document-grid">
                <div class="document-item">
                    <div class="document-label">
                        <i class="fas fa-id-card"></i>
                        Aadhaar Front
                    </div>
                    <div class="file-input-wrapper">
                        <input type="file" name="aadhaar_front" class="file-input" accept="image/*,.pdf">
                        <div class="file-input-display">
                            <div class="file-input-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="upload-text">Click to upload</div>
                                <div class="file-info">Images or PDF only</div>
                            </div>
                        </div>
                        <div class="file-name"></div>
                    </div>
                </div>

                <div class="document-item">
                    <div class="document-label">
                        <i class="fas fa-id-card"></i>
                        Aadhaar Back
                    </div>
                    <div class="file-input-wrapper">
                        <input type="file" name="aadhaar_back" class="file-input" accept="image/*,.pdf">
                        <div class="file-input-display">
                            <div class="file-input-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="upload-text">Click to upload</div>
                                <div class="file-info">Images or PDF only</div>
                            </div>
                        </div>
                        <div class="file-name"></div>
                    </div>
                </div>

                <div class="document-item">
                    <div class="document-label">
                        <i class="fas fa-credit-card"></i>
                        PAN Front
                    </div>
                    <div class="file-input-wrapper">
                        <input type="file" name="pan_front" class="file-input" accept="image/*,.pdf">
                        <div class="file-input-display">
                            <div class="file-input-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="upload-text">Click to upload</div>
                                <div class="file-info">Images or PDF only</div>
                            </div>
                        </div>
                        <div class="file-name"></div>
                    </div>
                </div>

                <div class="document-item">
                    <div class="document-label">
                        <i class="fas fa-credit-card"></i>
                        PAN Back
                    </div>
                    <div class="file-input-wrapper">
                        <input type="file" name="pan_back" class="file-input" accept="image/*,.pdf">
                        <div class="file-input-display">
                            <div class="file-input-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="upload-text">Click to upload</div>
                                <div class="file-info">Images or PDF only</div>
                            </div>
                        </div>
                        <div class="file-name"></div>
                    </div>
                </div>

                <div class="document-item" style="grid-column: 1 / -1;">
                    <div class="document-label">
                        <i class="fas fa-file-alt"></i>
                        Other Documents
                    </div>
                    <div class="file-input-wrapper">
                        <input type="file" name="other_docs" class="file-input" accept="image/*,.pdf,.doc,.docx">
                        <div class="file-input-display">
                            <div class="file-input-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="upload-text">Click to upload</div>
                                <div class="file-info">Images, PDF, or Documents</div>
                            </div>
                        </div>
                        <div class="file-name"></div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-upload"></i>
                Upload Documents
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.file-input').forEach(input => {
    input.addEventListener('change', function() {
        const wrapper = this.closest('.file-input-wrapper');
        const display = wrapper.querySelector('.file-input-display');
        const fileName = wrapper.querySelector('.file-name');
        const documentItem = wrapper.closest('.document-item');
        
        if (this.files && this.files[0]) {
            display.classList.add('file-selected');
            documentItem.classList.add('has-file');
            fileName.textContent = this.files[0].name;
            fileName.style.display = 'block';
            
            // Update the upload text
            const uploadText = display.querySelector('.upload-text');
            uploadText.textContent = 'File selected';
        } else {
            display.classList.remove('file-selected');
            documentItem.classList.remove('has-file');
            fileName.style.display = 'none';
            
            const uploadText = display.querySelector('.upload-text');
            uploadText.textContent = 'Click to upload';
        }
    });
});
</script>
@endsection