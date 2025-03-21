@extends('layout.base')
@section('title', 'Add New Attendances')
@section('content')
    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Attendance</h5>
            <form class="row" method="POST" action="{{ route('teacher.attendances.store') }}">
                @csrf

                <div class="mb-3 col-md-4">
                    <label for="classroom_id" class="form-label">Classroom<span class="text-danger">*</span></label>
                    <select class="form-control @error('classroom_id') is-invalid @enderror" id="classroom_id" name="classroom_id">
                        <option value="">Select Classroom</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" 
                                data-level="{{ $classroom->level_id }}" 
                                @selected(old('classroom_id') == $classroom->id)>
                                {{ $classroom->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-4">
                    <label for="subject_id" class="form-label">Subject<span class="text-danger">*</span></label>
                    <select class="form-control @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id">
                        <option value="">Select Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" 
                                data-level="{{ $subject->level_id }}"
                                @selected(old('subject_id') == $subject->id)>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-4">
                    <label for="date" class="form-label">Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                        name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div id="students-container" class="col-md-12 mb-3">
                    <div class="alert alert-info">Please select a classroom to view students</div>
                </div>
                
                <div class="mb-3 col-md-12">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note"
                        rows="3">{{ old('note') }}</textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    <a href="{{ route('teacher.attendances.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Create Attendance</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classroomSelect = document.getElementById('classroom_id');
            const subjectSelect = document.getElementById('subject_id');
            const submitBtn = document.getElementById('submitBtn');
            
            // Store original subject options for filtering
            const originalSubjectOptions = Array.from(subjectSelect.querySelectorAll('option'));
            
            // If there's a previously selected classroom (from validation error), load its students
            if (classroomSelect.value) {
                loadStudents(classroomSelect.value);
                filterSubjectsByClassroom(classroomSelect.value, originalSubjectOptions);
            }
            
            // Add event listeners
            classroomSelect.addEventListener('change', function() {
                const selectedClassroomId = this.value;
                loadStudents(selectedClassroomId);
                filterSubjectsByClassroom(selectedClassroomId, originalSubjectOptions);
            });
            
            // Add event listener for subject change to enable/disable submit button
            subjectSelect.addEventListener('change', function() {
                validateForm();
            });
        });
        
        function validateForm() {
            const classroomSelect = document.getElementById('classroom_id');
            const subjectSelect = document.getElementById('subject_id');
            const dateInput = document.getElementById('date');
            const submitBtn = document.getElementById('submitBtn');
            
            // Only enable submit if classroom, subject and date are selected and students are loaded
            const studentsLoaded = document.querySelectorAll('input[name="student_ids[]"]').length > 0;
            submitBtn.disabled = !classroomSelect.value || !subjectSelect.value || !dateInput.value || !studentsLoaded;
        }
        
        function filterSubjectsByClassroom(classroomId, originalOptions) {
            const subjectSelect = document.getElementById('subject_id');
            
            // Store the current selected value if any
            const currentValue = subjectSelect.value;
            
            // Clear current options
            subjectSelect.innerHTML = '';
            
            // Add the default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select Subject';
            subjectSelect.appendChild(defaultOption);
            
            if (!classroomId) {
                // If no classroom selected, show all subjects except the default
                originalOptions.forEach(option => {
                    if (option.value) { // Skip the default option
                        subjectSelect.appendChild(option.cloneNode(true));
                    }
                });
                subjectSelect.value = currentValue;
                return;
            }
            
            // Get classroom level using data attribute
            const classroomOption = document.querySelector(`#classroom_id option[value="${classroomId}"]`);
            if (!classroomOption) {
                console.error('Classroom option not found');
                return;
            }
            
            const classroomLevel = classroomOption.getAttribute('data-level');
            
            if (!classroomLevel) {
                console.warn('Classroom level not found, showing all subjects');
                // If level not found, show all subjects
                originalOptions.forEach(option => {
                    if (option.value) {
                        subjectSelect.appendChild(option.cloneNode(true));
                    }
                });
                subjectSelect.value = currentValue;
                return;
            }
            
            // Filter and add matching subjects
            let matchFound = false;
            originalOptions.forEach(option => {
                if (option.value && option.getAttribute('data-level') === classroomLevel) {
                    subjectSelect.appendChild(option.cloneNode(true));
                    matchFound = true;
                }
            });
            
            // If no matching subjects found, show a message
            if (!matchFound && classroomId) {
                const noMatchOption = document.createElement('option');
                noMatchOption.disabled = true;
                noMatchOption.textContent = 'No subjects available for this classroom level';
                subjectSelect.appendChild(noMatchOption);
            }
            
            // Try to restore previous selection if it's still valid
            if (currentValue) {
                const stillExists = Array.from(subjectSelect.options).some(opt => opt.value === currentValue);
                subjectSelect.value = stillExists ? currentValue : '';
            } else {
                subjectSelect.value = '';
            }
            
            // Validate form after changing subjects
            validateForm();
        }
        
        function loadStudents(classroomId) {
            const studentsContainer = document.getElementById('students-container');
            const submitBtn = document.getElementById('submitBtn');
            
            studentsContainer.innerHTML = ''; // Clear previous students
            
            if (!classroomId) {
                studentsContainer.innerHTML = '<div class="alert alert-info">Please select a classroom to view students</div>';
                submitBtn.disabled = true;
                return;
            }
            
            // Show loading indicator
            studentsContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            
            // Create student list container
            const studentsList = document.createElement('div');
            studentsList.className = 'row mt-2';
            
            // Add header with select all functionality
            const headerRow = document.createElement('div');
            headerRow.className = 'col-12 mb-3 d-flex justify-content-between align-items-center';
            headerRow.innerHTML = `
                <h6 class="mb-0">Student Attendance</h6>
                <div class="form-check form-check-inline">
                    <select id="bulk-action" class="form-select form-select-sm" onchange="applyBulkAction(this.value)">
                        <option value="">Bulk Action</option>
                        <option value="present">Mark All Present</option>
                        <option value="absent">Mark All Absent</option>
                        <option value="late">Mark All Late</option>
                    </select>
                </div>
            `;
            studentsList.appendChild(headerRow);
            
            let studentsFound = false;
            
            @foreach ($students as $student)
                if ("{{ $student->classroom_id }}" === classroomId) {
                    studentsFound = true;
                    const studentRow = document.createElement('div');
                    studentRow.className = 'col-md-6 mb-3';
                    studentRow.innerHTML = `
                        <div class="p-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <label class="form-label mb-0 fw-bold">{{ $student->name }}</label>
                                    <input type="hidden" name="student_ids[]" value="{{ $student->id }}">
                                    <select class="form-select attendance-select" name="attendance_status[]">
                                        <option value="present">Present</option>
                                        <option value="late">Late</option>
                                        <option value="absent">Absent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    `;
                    studentsList.appendChild(studentRow);
                }
            @endforeach
            
            if (!studentsFound) {
                studentsContainer.innerHTML = '<div class="alert alert-warning">No students found in this classroom</div>';
                submitBtn.disabled = true;
                return;
            }
            
            studentsContainer.innerHTML = '';
            studentsContainer.appendChild(studentsList);
            
            // Validate form after loading students
            validateForm();
        }
        
        function applyBulkAction(action) {
            if (!action) return;
            
            const selects = document.querySelectorAll('.attendance-select');
            selects.forEach(select => {
                select.value = action;
            });
        }
    </script>
@endpush
