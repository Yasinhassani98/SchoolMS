@extends('layout.base')
@section('title', 'Add New Subject')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Subject</h5>
            <form class="row" method="POST" action="{{ route('admin.subjects.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Subject Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
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
                <div class="mb-3 col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                        cols="30" rows="10">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <label for="file">تحميل ملف المادة (اختياري):</label>
                <input type="file" name="file" id="file" accept=".pdf">
                <div class="col-md-12 d-flex justify-content-end">
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Subject</button>
                </div>
            </form>
        </div>
    </div>
@endsection
