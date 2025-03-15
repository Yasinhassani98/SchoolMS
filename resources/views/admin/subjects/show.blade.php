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
            <div class="d-flex justify-content-end">
                <button href="{{ route('admin.subjects.index') }}" class="btn btn-gray mx-2">Back</button>
                <button href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
@endsection