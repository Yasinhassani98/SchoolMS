@extends('layout.base')
@section('title', 'Parent Details')
@section('content')

    <div class="card mb-4 mt-4 shadow">
        <div class="card-header bg-primary text-white justify-content-center d-flex">
            <h5 class="card-title mb-0">Parent Details</h5>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-12 text-center mb-4">
                    <img src="{{ $parent->getImageURL() }}" alt="{{ $parent->name }}'s Profile Picture"
                        class="img-fluid rounded-circle shadow-sm" style="width: 200px; height: 200px; object-fit: cover;"
                        loading="lazy">
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Parent Name:</strong>
                        <p class="mb-0">{{ $parent->name }}</p>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Email:</strong>
                        <p class="mb-0">{{ $parent->user->email }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Phone:</strong>
                        <p class="mb-0">{{ $parent->phone }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Date of birth:</strong>
                        <p class="mb-0">{{ $parent->date_of_birth }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Number of children:</strong>
                        <p class="mb-0">{{ $childrenNumber }}</p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.parents.index') }}" class="btn btn-outline-secondary mx-2">Back</a>
                <a href="{{ route('admin.parents.edit', $parent->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@endsection
