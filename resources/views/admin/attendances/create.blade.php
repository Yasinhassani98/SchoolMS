@extends('layout.base')
@section('title', 'Add New Attendances')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Attendance</h5>
            <form class="row" method="POST" action="{{ route('attendances.store') }}">
                @csrf
@role(['admin','superadmin'])
                <div class="mb-3 col-md-6">
                    <label for="teacher_id" class="form-label">teacher<span class="text-danger">*</span></label>
                    <select class="form-control @error('student_id') is-invalid @enderror" id="teacher_id"
                        name="teacher_id">
                        <option value="">Select teacher</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" 
                                @selected(old('teacher_id') == $teacher->id)>{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
@endrole
                <div class="mb-3 col-md-6">
                    <label for="student_id" class="form-label">Student<span class="text-danger">*</span></label>
                    <select class="form-control @error('student_id') is-invalid @enderror" id="student_id"
                        name="student_id">
                        <option value="">Select Student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" data-level="{{ $student->classroom->level->level }}"
                                @selected(old('student_id') == $student->id)>{{ $student->name }}</option>
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
                                @selected(old('subject_id') == $subject->id)>{{ $subject->level->level . ' ' . $subject->name }}</option>
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
                            <option value="{{ $classroom->id }}" @selected(old('classroom_id') == $classroom->id)>{{ $classroom->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="academic_year_id" class="form-label">Academic Year<span class="text-danger">*</span></label>
                    <select class="form-control @error('academic_year_id') is-invalid @enderror" id="academic_year_id"
                        name="academic_year_id">
                        <option value="">Select Academic Year</option>
                        @foreach ($academicYears as $academicYear)
                            <option value="{{ $academicYear->id }}" @selected(old('academic_year_id') == $academicYear->id)>{{ $academicYear->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('academic_year_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="present" @selected(old('status') == 'present')>present</option>
                        <option value="absent" @selected(old('status') == 'absent')>absent</option>
                        <option value="late" @selected(old('status') == 'late')>late</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="date" class="form-label">date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                        name="date" value="{{ old('date') }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3 col-md-6">
                    <label for="note" class="form-label">note<span class="text-danger">*</span></label>
                    <input class="form-control @error('note') is-invalid @enderror" id="note"
                        name="note" value="{{ old('note') }}" required>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Create date</button>
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
