@extends('layout.base')
@section('title', 'Student Details')
@section('content')

    <div class="card mb-4 mt-4 shadow">
        <div class="card-header bg-primary text-white justify-content-center d-flex">
            <h5 class="card-title mb-0">Student Details</h5>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-12 text-center mb-4">
                    <img src="{{ $student->getImageURL() }}" alt="{{ $student->name }}'s Profile Picture"
                        class="img-fluid rounded-circle shadow-sm" style="width: 200px; height: 200px; object-fit: cover;"
                        loading="lazy">
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Student Name:</strong>
                        <p class="mb-0">{{ $student->name }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Student Gender:</strong>
                        <p class="mb-0">{{ $student->gender }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Classroom Name:</strong>
                        <p class="mb-0">{{ $student->classroom->name }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Email:</strong>
                        <p class="mb-0">{{ $student->email }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Phone:</strong>
                        <p class="mb-0">{{ $student->phone }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Enrollment Date:</strong>
                        <p class="mb-0">{{ $student->enrollment_date }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Address:</strong>
                        <p class="mb-0">{{ $student->address }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Date of Birth:</strong>
                        <p class="mb-0">{{ $student->date_of_birth }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Parent Phone:</strong>
                        <p class="mb-0">{{ $student->parent_phone }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Status:</strong>
                        <p class="mb-0">{{ ucfirst($student->status) }}</p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary mx-2">Back</a>
                <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@endsection
