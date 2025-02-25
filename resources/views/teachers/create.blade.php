@extends('layout.base')
@section('title', 'Add New teacher')
@section('content')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card mb-4 mt-2 container">
<div class="card-body p-4">
    <h5 class="card-title">Add New teacher</h5>
    <form class="row" action="{{ route('teachers.store') }}" method="POST">
        @csrf
        <div class="mb-3 col-md-6">
            <label for="name" class="form-label">teacher Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="grade_level" class="form-label">Classroom</label>
            <input type="number" class="form-control @error('classroom') is-invalid @enderror" id="classroom"
                name="classroom_id" value="{{ old('classroom') }}" required>
            @error('classroom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="Email" class="form-label">Email</label>
            <input type="email" class="form-control @error('Email') is-invalid @enderror" id="Email"
                name="Email" value="{{ old('Email') }}" required>
            @error('Email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="Phone" class="form-label">Phone</label>
            <input type="number" class="form-control @error('Phone') is-invalid @enderror" id="Phone"
                name="Phone" value="{{ old('Phone') }}" required>
            @error('Phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="specialization" class="form-label">specialization</label>
            <input type="date" class="form-control @error('specialization') is-invalid @enderror"
                id="specialization" name="specialization" value="{{ old('specialization') }}" required>
            @error('specialization')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>



        <div class="mb-3 col-md-6">
            <label for="status" class="form-label">Status</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                <option value="active" @selected(old('status') == 'active')>Active</option>
                <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Add teacher</button>
        </div>
    </form>
</div>
</div>
@endsection