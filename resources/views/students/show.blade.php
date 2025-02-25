@extends('layout.base')
@section('title', 'Student Details')
@section('content')
    
    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Student Details</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Student Name:</strong>
                    <p>{{ $student->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Classroom Name:</strong>
                    <p>{{ $student->classroom->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Email:</strong>
                    <p>{{ $student->email }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Phone:</strong>
                    <p>{{ $student->phone }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Enrollment Date:</strong>
                    <p>{{ $student->enrollment_date }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Address:</strong>
                    <p>{{ $student->address }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Date of Birth:</strong>
                    <p>{{ $student->date_of_birth }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Parent Phone:</strong>
                    <p>{{ $student->parent_phone }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong>
                    <p>{{ ucfirst($student->status) }}</p>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button href="{{ route('students.index') }}" class="btn btn-gray mx-2">Back</button>
                <button href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
@endsection