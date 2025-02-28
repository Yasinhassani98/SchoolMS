@extends('layout.base')
@section('title', 'Edit Subject')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Edit Subject {{ $subject->name }}</h5>
            <form class="row" method="POST" action="{{ route('subjects.store') }}">
                @csrf
                @method('PUT')
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Subject Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name',$subject->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="level_id" class="form-label">Level</label>
                    <select class="form-control @error('level_id') is-invalid @enderror" id="level_id" name="level_id">
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}" @selected(old('level_id',$subject->level_id) == $level->id)>{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('level_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                        cols="30" rows="10">{{ old('description',$subject->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                        <option value="required" @selected(old('type',$subject->type) == 'required')>Required</option>
                        <option value="optional" @selected(old('type',$subject->type) == 'optional')>Optional</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Subject</button>
                </div>
            </form>
        </div>
    </div>
@endsection
