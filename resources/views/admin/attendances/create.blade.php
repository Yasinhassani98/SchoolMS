@extends('layout.base')
@section('title', 'Add New Attendances')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Attendance</h5>
            <form class="row" method="POST" action="{{ route('admin.attendances.store') }}">
                @csrf
                @role(['admin','superadmin'])
                <div class="mb-3 col-md-6">
                    <label for="teacher_id" class="form-label">Teacher<span class="text-danger">*</span></label>
                    <select class="form-control @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id">
                        <option value="">Select Teacher</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @selected(old('teacher_id') == $teacher->id)>{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @endrole

                <div class="mb-3 col-md-6">
                    <label for="classroom_id" class="form-label">Classroom<span class="text-danger">*</span></label>
                    <select class="form-control @error('classroom_id') is-invalid @enderror" id="classroom_id" name="classroom_id">
                        <option value="">Select Classroom</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" @selected(old('classroom_id') == $classroom->id)>{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>



                <div class="mb-3 col-md-6">
                    <label for="subject_id" class="form-label">Subject<span class="text-danger">*</span></label>
                    <select class="form-control @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id">
                        <option value="">Select Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" data-level="{{ $subject->level->level }}"
                                @selected(old('subject_id') == $subject->id)>{{ $subject->level->level . ' ' . $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <div class="mb-3 col-md-6">
                    <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="present" @selected(old('status') == 'present')>Present</option>
                        <option value="absent" @selected(old('status') == 'absent')>Absent</option>
                        <option value="late" @selected(old('status') == 'late')>Late</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="mb-3 col-md-6">
                    <label for="date" class="form-label">Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                        name="date" value="{{ old('date') }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                <div id="students-container" class="col-md-12">
                    <!-- Student attendance inputs will be dynamically inserted here -->
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
                    <a href="{{ route('admin.attendances.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Attendance</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('classroom_id').addEventListener('change', function() {
            const selectedClassroomId = this.value;
            const studentsContainer = document.getElementById('students-container');

            studentsContainer.innerHTML = ''; // Clear previous students

            if (selectedClassroomId) {
                const studentsList = document.createElement('div');
                studentsList.className = 'row mt-4';
                studentsList.innerHTML = '<h6 class="col-12 mb-3">Student Attendance</h6>';

                @foreach ($students as $student)
                    if ("{{ $student->classroom->id }}" === selectedClassroomId) {
                        const studentRow = document.createElement('div');
                        studentRow.className = 'col-md-6 mb-3 d-flex align-items-center';
                        studentRow.innerHTML = `
                            <div class="flex-grow-1">
                                <label class="form-label">{{ $student->name }}</label>
                                <input type="hidden" name="student_ids[]" value="{{ $student->id }}">
                                <select class="form-control" name="attendance_status[]">
                                    <option value="present">Present</option>
                                    <option value="late">Late</option>
                                    <option value="absent">Absent</option>
                                </select>
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
