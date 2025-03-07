@extends('layout.base')
@section('title', 'Teacher Details')
@section('content')
    <div class="card mb-4 mt-4 shadow">
        <div class="card-header bg-primary text-white justify-content-center d-flex">
            <h5 class="card-title mb-0">Teacher Details</h5>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-12 text-center mb-4">
                    <img src="{{ $teacher->getImageURL() }}" alt="Profile Picture"
                        class="img-fluid rounded-circle object-fit-contain shadow-sm" style="width: 200px; height: 200px;"
                        lodaing="lazy">
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">teacher Name:</strong>
                        <p class="mb-0">{{ $teacher->name ?? 'null' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">teacher Gender:</strong>
                        <p class="mb-0">{{ $teacher->gender ?? 'null' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Email:</strong>
                        <p class="mb-0">{{ $teacher->email }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Phone:</strong>
                        <p class="mb-0">{{ $teacher->phone }}</p>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Date of Birth:</strong>
                        <p class="mb-0">{{ $teacher->date_of_birth }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Specialization:</strong>
                        <p class="mb-0">{{ $teacher->specialization }}</p>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Status:</strong>
                        <p class="mb-0">{{ ucfirst($teacher->status) }}</p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary mx-2">Back</a>
                <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@endsection
