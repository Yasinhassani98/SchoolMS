@extends('layout.base')
@section('title', 'Edit Mark')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Edit Mark</h5>
            <form class="row" method="POST" action="{{ route('teacher.marks.update', $mark->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3 col-md-6">
                    <label for="student_id" class="form-label">Student<span class="text-danger">*</span></label>
                    <select class="form-control @error('student_id') is-invalid @enderror" id="student_id"
                        name="student_id">
                        <option value="">Select Student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" 
                                data-level="{{ $student->classroom->level->level }}"
                                data-level-id="{{ $student->classroom->level->id }}"
                                @selected(old('student_id', $mark->student_id) == $student->id)>{{ $student->name }}</option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="subject_id" class="form-label">Subject<span class="text-danger">*</span></label>
                    <select class="form-control @error('subject_id') is-invalid @enderror" id="subject_id"
                        name="subject_id">
                        <option value="">Select Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" data-level="{{ $subject->level->level }}"
                                @selected(old('subject_id', $mark->subject_id) == $subject->id)>{{ $subject->level->level . ' ' . $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="classroom_id" class="form-label">Classroom<span class="text-danger">*</span></label>
                    <select class="form-control @error('classroom_id') is-invalid @enderror" id="classroom_id"
                        name="classroom_id">
                        <option value="">Select Classroom</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" 
                                data-level="{{ $classroom->level->level }}"
                                data-level-id="{{ $classroom->level->id }}"
                                @selected(old('classroom_id', $mark->classroom_id) == $classroom->id)>{{ $classroom->level->level . ' ' . $classroom->name }}</option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="mark" class="form-label">Mark<span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('mark') is-invalid @enderror" id="mark"
                        name="mark" value="{{ old('mark', $mark->mark) }}" required>
                    @error('mark')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 col-md-12">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note"
                        cols="30" rows="5">{{ old('note', $mark->note) }}</textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-12 d-flex justify-content-end">
                    <a href="{{ route('teacher.marks.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Mark</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Function to filter classrooms and subjects based on student level
        function filterByStudentLevel() {
            var studentSelect = document.getElementById('student_id');
            var selectedOption = studentSelect.options[studentSelect.selectedIndex];
            
            if (selectedOption.value === "") {
                return; // No student selected
            }
            
            var selectedStudentLevel = selectedOption.getAttribute('data-level');
            var selectedLevelId = selectedOption.getAttribute('data-level-id');
            
            // Filter subjects based on student level
            var subjectSelect = document.getElementById('subject_id');
            var subjectOptions = subjectSelect.options;

            for (var i = 0; i < subjectOptions.length; i++) {
                var option = subjectOptions[i];
                var subjectLevel = option.getAttribute('data-level');

                if (subjectLevel === selectedStudentLevel || option.value === "") {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
            
            // Filter classrooms based on student level
            var classroomSelect = document.getElementById('classroom_id');
            var classroomOptions = classroomSelect.options;
            
            for (var j = 0; j < classroomOptions.length; j++) {
                var classroomOption = classroomOptions[j];
                var classroomLevelId = classroomOption.getAttribute('data-level-id');
                
                if (classroomLevelId === selectedLevelId || classroomOption.value === "") {
                    classroomOption.style.display = 'block';
                } else {
                    classroomOption.style.display = 'none';
                }
            }
        }

        // Add event listener for student selection change
        document.getElementById('student_id').addEventListener('change', function() {
            var selectedStudentLevel = this.options[this.selectedIndex].getAttribute('data-level');
            var selectedLevelId = this.options[this.selectedIndex].getAttribute('data-level-id');
            
            // Filter subjects based on student level
            var subjectSelect = document.getElementById('subject_id');
            var subjectOptions = subjectSelect.options;

            for (var i = 0; i < subjectOptions.length; i++) {
                var option = subjectOptions[i];
                var subjectLevel = option.getAttribute('data-level');

                if (subjectLevel === selectedStudentLevel || option.value === "") {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
            
            if (this.value !== "") {
                // Only reset if a new student is selected
                subjectSelect.value = ""; 
            }
            
            // Filter classrooms based on student level
            var classroomSelect = document.getElementById('classroom_id');
            var classroomOptions = classroomSelect.options;
            
            for (var j = 0; j < classroomOptions.length; j++) {
                var classroomOption = classroomOptions[j];
                var classroomLevelId = classroomOption.getAttribute('data-level-id');
                
                if (classroomLevelId === selectedLevelId || classroomOption.value === "") {
                    classroomOption.style.display = 'block';
                } else {
                    classroomOption.style.display = 'none';
                }
            }
            
            if (this.value !== "") {
                // Only reset if a new student is selected
                classroomSelect.value = ""; 
            }
        });
        
        // Run the filter on page load to handle pre-selected values
        document.addEventListener('DOMContentLoaded', function() {
            filterByStudentLevel();
        });
    </script>
@endpush
