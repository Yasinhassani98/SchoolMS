@extends('layout.base')
@section('title', 'Add Academic Year')
@section('content')
    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Academic Year</h5>
            <form class="row" action="{{ route('admin.academic-years.store') }}" method="POST">
                @csrf
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required placeholder="e.g. 2023-2024">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="start_date" class="form-label">Start Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                        name="start_date" value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="end_date" class="form-label">End Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                        name="end_date" value="{{ old('end_date') }}" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" id="is_current" name="is_current" value="1" 
                            {{ old('is_current') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_current">
                            Set as current academic year
                        </label>
                    </div>
                    @error('is_current')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <a href="{{ route('admin.academic-years.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Academic Year</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        startDateInput.addEventListener('change', function() {
            // Set minimum end date to be after start date
            endDateInput.min = startDateInput.value;
            
            // If end date is before start date, clear it
            if (endDateInput.value && endDateInput.value < startDateInput.value) {
                endDateInput.value = '';
            }
        });
    });
</script>
@endpush