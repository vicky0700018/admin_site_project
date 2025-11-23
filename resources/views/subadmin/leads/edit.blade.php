@extends('app')

@section('styles')
<style>
    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .form-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px;
        background: white;
        border-radius: 20px 20px 0 0;
    }

    .form-header h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-body {
        padding: 2.5rem 2rem;
        background: white;
    }

    .form-group {
        margin-bottom: 1.75rem;
        position: relative;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }

    .form-label i {
        color: #f39c12;
        margin-right: 0.5rem;
        font-size: 1.1rem;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafbfc;
    }

    .form-control:focus {
        border-color: #f39c12;
        box-shadow: 0 0 0 0.2rem rgba(243, 156, 18, 0.15);
        background: white;
        transform: translateY(-1px);
    }

    .form-control.is-invalid {
        border-color: var(--danger);
        background: #fff5f5;
    }

    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafbfc;
        cursor: pointer;
    }

    .form-select:focus {
        border-color: #f39c12;
        box-shadow: 0 0 0 0.2rem rgba(243, 156, 18, 0.15);
        background: white;
    }

    .invalid-feedback {
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
    }

    .invalid-feedback::before {
        content: '⚠';
        margin-right: 0.5rem;
    }

    .btn {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        font-size: 0.95rem;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
    }

    .form-actions {
        background: #f8f9fa;
        margin: 0 -2rem -2.5rem -2rem;
        padding: 1.5rem 2rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .edit-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background: #f39c12;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(243, 156, 18, 0.3);
    }

    /* Field highlight for edited fields */
    .form-control[value]:not([value=""]) {
        background: linear-gradient(135deg, #fff3cd 0%, #fdf2e9 100%);
        border-color: #ffc107;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-body {
            padding: 1.5rem 1rem;
        }

        .form-header {
            padding: 1.5rem 1rem;
        }

        .form-header h3 {
            font-size: 1.5rem;
        }

        .form-actions {
            margin: 0 -1rem -1.5rem -1rem;
            padding: 1rem;
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            width: 100%;
        }

        .edit-badge {
            position: relative;
            top: 0;
            right: 0;
            margin-bottom: 1rem;
            display: inline-block;
        }
    }
</style>
@endsection

@section('content')
<div class="content">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="form-card">
                <!-- Header -->
                <div class="form-header">
                    <div class="edit-badge">
                        <i class="fas fa-edit me-1"></i>Edit Mode
                    </div>
                    <h3>
                        <i class="fas fa-user-edit"></i>
                        Update Lead Information
                    </h3>
                </div>

                <!-- Body -->
                <div class="form-body">

                    <form action="{{ route('subadmin.leads.update', $lead->id) }}" method="POST">
                        @csrf

                        <!-- Full Name -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user"></i>
                                Full Name
                            </label>
                            <input type="text" name="name" 
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $lead->name) }}" required>
                            @error('name') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope"></i>
                                Email Address
                            </label>
                            <input type="email" name="email" 
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $lead->email) }}" required>
                            @error('email') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <!-- Mobile -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone"></i>
                                Mobile Number
                            </label>
                            <input type="text" name="mobile" 
                                class="form-control @error('mobile') is-invalid @enderror"
                                value="{{ old('mobile', $lead->mobile) }}" required>
                            @error('mobile') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="row">
                            <!-- DOB -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        Date of Birth
                                    </label>
                                    <input type="date" name="dob" 
                                        class="form-control" 
                                        value="{{ old('dob', $lead->dob ? $lead->dob->format('Y-m-d') : '') }}">
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-venus-mars"></i>
                                        Gender
                                    </label>
                                    <select name="gender" class="form-select">
                                        <option value="">-- Select Gender --</option>
                                        <option value="male" {{ old('gender', $lead->gender)=='male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $lead->gender)=='female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $lead->gender)=='other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('subadmin.leads.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Update Lead
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection