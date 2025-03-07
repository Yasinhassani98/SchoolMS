@extends('layout.base')
@section('title', 'Add New Classroom')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New name</h5>
            <form class="row" method="POST" action="{{ route('classrooms.store') }}">
                @csrf
                <div class="mb-3 col-md-6">
                    <label for="level_id" class="form-label">Level<span class="text-danger">*</span></label>
                    <select class="form-control @error('level_id') is-invalid @enderror" id="level_id" name="level_id">
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}" @selected(old('level_id') == $level->id)>{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('level_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Create Classroom</button>
                </div>
            </form>
        </div>
    </div>
@endsection
