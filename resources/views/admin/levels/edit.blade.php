@extends('layout.base')
@section('title', 'Edit Level')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Edit Level {{ $level->level }}</h5>
            <form class="row" method="POST" action="{{ route('admin.levels.update',$level->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">level Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name',$level->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="level" class="form-label">level<span class="text-danger">*</span></label>
                    <input type="number" step="1" class="form-control @error('level') is-invalid @enderror" id="level"
                        name="level" value="{{ old('level',$level->level) }}" required>
                    @error('level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update level</button>
                </div>
            </form>
        </div>
    </div>
@endsection
