@extends('layout.base')
@section('title', 'Academic Year Details')
@section('content')
    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title">Academic Year Details</h5>
                <div>
                    <a href="{{ route('admin.academic-years.edit', $academicYear->id) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.academic-years.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">Name:</h6>
                    <p>{{ $academicYear->name }}</p>
                </div>
                
                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">Status:</h6>
                    <p>
                        @if($academicYear->is_current)
                            <span class="badge bg-success">Current Academic Year</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </p>
                </div>
                
                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">Start Date:</h6>
                    <p>{{ \Carbon\Carbon::parse($academicYear->start_date)->format('d M, Y') }}</p>
                </div>
                
                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">End Date:</h6>
                    <p>{{ \Carbon\Carbon::parse($academicYear->end_date)->format('d M, Y') }}</p>
                </div>
                
                <div class="col-md-12 mb-3">
                    <h6 class="fw-bold">Duration:</h6>
                    <p>{{ \Carbon\Carbon::parse($academicYear->start_date)->diffInMonths($academicYear->end_date) }} months</p>
                </div>
                
                <div class="col-md-12 mb-3">
                    <h6 class="fw-bold">Description:</h6>
                    <p>{{ $academicYear->description ?? 'No description available' }}</p>
                </div>
                
            </div>
            
            @if(!$academicYear->is_current)
                <div class="mt-4">
                    <form action="{{ route('admin.academic-years.set-current', $academicYear->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check-circle"></i> Set as Current Academic Year
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection