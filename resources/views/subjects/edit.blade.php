@extends('layout.base')

@section('title', 'Edit Subject')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Edit Subject</h5>
            <form method="POST" action="{{ route('subjects.update',$subject->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Student Name</label>
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
                            <option value="{{ $level->id }}" @selected(old('level_id',$subject->id) == $level->id)>{{ $level->name }}</option>
                            
                        @endforeach
                    </select>
                    @error('level_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="" cols="30" rows="10">{{ old('description',$subject->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                        <option value="required" @selected(old('type',$subject->type) == 'required')>required</option>
                        <option value="optional" @selected(old('type',$subject->type) == 'optional')>optional</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update Subject</button>
            </form>
        </div>
    </div>
@endsection
