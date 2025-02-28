@extends('layout.base')
@section('title', 'Add New Mark')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Mark</h5>
            <form class="row" method="POST" action="{{ route('marks.store') }}">
                @csrf
                <div class="mb-3 col-md-6">
                    <label for="student_id" class="form-label">Student</label>
                    <select class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id">
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>{{ $student->name }}</option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="subject_id" class="form-label">Subject</label>
                    <select class="form-control @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="mark" class="form-label">Mark</label>
                    <input type="number" class="form-control @error('mark') is-invalid @enderror" id="mark"
                        name="mark" value="{{ old('mark') }}" required>
                    @error('mark')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Create Mark</button>
                </div>
            </form>
        </div>
    </div>
@endsection
