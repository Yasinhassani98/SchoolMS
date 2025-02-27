@extends('layout.base')
@section('title', 'Student Details')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Student Details</h5>
            <div class="row">
                <div class="col-md-12 mt-3 mb-3">
                    <img src="{{ asset('storage/' . $student->image) ?? 'null' }}" alt="Profile Picture"
                        class="img-fluid rounded-circle object-fit-contain" style="width: 200px; height: 200px;">
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Student Name:</strong>
                    <p>{{ $student->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Classroom Name:</strong>
                    <p>{{ $student->classroom->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Email:</strong>
                    <p>{{ $student->email }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Phone:</strong>
                    <p>{{ $student->phone }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Enrollment Date:</strong>
                    <p>{{ $student->enrollment_date }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Address:</strong>
                    <p>{{ $student->address }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Date of Birth:</strong>
                    <p>{{ $student->date_of_birth }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Parent Phone:</strong>
                    <p>{{ $student->parent_phone }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Status:</strong>
                    <p>{{ ucfirst($student->status) }}</p>
                </div>

            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('students.index') }}" class="btn btn-gray mx-2">Back</a>
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@endsection
