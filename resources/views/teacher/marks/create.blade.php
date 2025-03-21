@extends('layout.base')
@section('title', 'Add New Mark')
@section('content')
    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Mark</h5>
            <form class="row" method="POST" action="{{ route('teacher.marks.store') }}">
                @csrf

                <div class="mb-3 col-md-6">
                    <label for="classroom_id" class="form-label">Classroom<span class="text-danger">*</span></label>
                    <select class="form-control @error('classroom_id') is-invalid @enderror" id="classroom_id"
                        name="classroom_id">
                        <option value="">Select Classroom</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" 
                                @selected(old('classroom_id') == $classroom->id)>{{ $classroom->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="subject_id" class="form-label">Subject<span class="text-danger">*</span></label>
                    <select class="form-control @error('subject_id') is-invalid @enderror" id="subject_id"
                        name="subject_id" disabled>
                        <option value="">Select Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" 
                                @selected(old('subject_id') == $subject->id)>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="students-container" class="col-md-12">
                    <!-- Student marks will be dynamically inserted here -->
                </div>

                <div class="mb-3 col-md-12">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note"
                        cols="30" rows="10">{{ old('note') }}</textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <a href="{{ route('teacher.marks.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Marks</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('classroom_id').addEventListener('change', function() {
            const selectedClassroomId = this.value;
            const subjectSelect = document.getElementById('subject_id');
            const studentsContainer = document.getElementById('students-container');
            
            // Reset and clear dependent elements
            subjectSelect.disabled = !selectedClassroomId;
            studentsContainer.innerHTML = '';
            
            if (selectedClassroomId) {
                // Filter and display students with mark inputs
                const studentsList = document.createElement('div');
                studentsList.className = 'row mt-4';
                studentsList.innerHTML = '<h6 class="col-12 mb-3">Student Marks</h6>';

                @foreach ($students as $student)
                    if ("{{ $student->classroom_id }}" === selectedClassroomId) {
                        const studentRow = document.createElement('div');
                        studentRow.className = 'col-md-6 mb-3 d-flex align-items-center';
                        studentRow.innerHTML = `
                            <div class="flex-grow-1">
                                <label class="form-label">{{ $student->name }}</label>
                                <input type="hidden" name="student_ids[]" value="{{ $student->id }}">
                                <input type="number" class="form-control" name="mark_values[]" placeholder="Enter mark" min="0" max="100" required>
                            </div>
                        `;
                        studentsList.appendChild(studentRow);
                    }
                @endforeach

                studentsContainer.appendChild(studentsList);
            }
        });
    </script>
@endpush
