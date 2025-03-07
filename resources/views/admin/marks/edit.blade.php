@extends('layout.base')
@section('title', 'Edit Mark')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Edit Mark</h5>
            <form class="row" method="POST" action="{{ route('marks.update',$mark->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3 col-md-6">
                    <label for="student_id" class="form-label">Student<span class="text-danger">*</span></label>
                    <select class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id">
                        <option value="">Select Student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" data-level="{{ $student->classroom->level->level }}" @selected(old('student_id', $mark->student_id) == $student->id)>{{ $student->name }}</option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="subject_id" class="form-label">Subject<span class="text-danger">*</span></label>
                    <select class="form-control @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id">
                        <option value="">Select Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" data-level="{{ $subject->level->level }}" @selected(old('subject_id',$mark->subject_id) == $subject->id)>{{ $subject->level->level ." ". $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="mark" class="form-label">Mark<span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('mark') is-invalid @enderror" id="mark"
                        name="mark" value="{{ old('mark',$mark->mark) }}" required>
                    @error('mark')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Mark</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('student_id').addEventListener('change', function() {
            var selectedStudentLevel = this.options[this.selectedIndex].getAttribute('data-level');
            var subjectSelect = document.getElementById('subject_id');
            var options = subjectSelect.options;

            for (var i = 0; i < options.length; i++) {
                var option = options[i];
                var subjectLevel = option.getAttribute('data-level');

                if (subjectLevel === selectedStudentLevel || option.value === "") {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }

            subjectSelect.value = ""; // Reset subject selection
        });
    </script>
@endpush