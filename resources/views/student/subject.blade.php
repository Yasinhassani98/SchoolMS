@extends('layout.base')
@section('title', 'Subject Details')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Subject Details</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Subject Name:</strong>
                    <p>{{ $subject->name ?? '' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Level Name:</strong>
                    <p>{{ $subject->level->name ?? '' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-secondary">Description:</strong>
                    <p>{{ $subject->description ?? '' }}</p>
                </div>
            </div>

            @if($subject->file)
            <div class="mb-3">
                <strong class="text-secondary">Subject File</strong>
                <div class="mt-2">
                    <a href="{{ Storage::url($subject->file) }}" class="btn btn-sm btn-outline-success ms-2" download>
                        <i class="fas fa-download me-1"></i> Download
                    </a>
                </div>
            </div>
            @endif

            <div class="d-flex justify-content-end">
                <button href="{{ route('admin.subjects.index') }}" class="btn btn-gray mx-2">Back</button>
                <button href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
@endsection