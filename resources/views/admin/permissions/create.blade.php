@extends('layout.base')
@section('title', 'Create Permission')
@section('content')
    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Create New Permission</h5>
            <form class="row" action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                <div class="mb-3 col-md-12">
                    <label for="name" class="form-label">Permission Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required placeholder="Enter permission name (e.g. view-users)">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Use a descriptive name like "create-users" or "edit-roles". Permissions should follow a verb-noun pattern.
                    </small>
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Permission</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .card-title {
            color: var(--primary-color);
        }
    </style>
@endpush