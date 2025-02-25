@extends('layout.base')
@section('title', 'Add New Level')
@section('content')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title">Add New Level</h5>
                                <a href="{{ route('levels.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to Level List
                                </a>
                            </div>
                            <form action="{{ route('levels.store') }}" method="post">
                                @csrf
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="level" class="form-label">Level</label>
                                    <input type="number" step="1" class="form-control @error('level') is-invalid @enderror" id="level" name="level" value="{{ old('level') }}" required>
                                    @error('level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-block shadow mt-4">Add Level</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection