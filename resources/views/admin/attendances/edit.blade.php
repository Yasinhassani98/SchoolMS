@extends('layout.base')
@section('title', 'Edit Attendance')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Edit Attendance</h5>
            <form class="row" method="POST" action="{{ route('admin.attendances.update', $attendance->id) }}">
                @csrf
                @method('PUT')

                @role(['admin','superadmin'])
                <div class="mb-3 col-md-6">
                    <label for="teacher_id" class="form-label">Teacher<span class="text-danger">*</span></label>
                    <select class="form-control @error('teacher_id') is-invalid @enderror" id="teacher_id"
                        name="teacher_id">
                        <option value="">Select Teacher</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" 
                                @selected(old('teacher_id', $attendance->teacher_id) == $teacher->id)>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
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
                                @selected(old('student_id', $attendance->student_id) == $student->id)>
                                {{ $student->name }}
                            </option>
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
                                @selected(old('subject_id', $attendance->subject_id) == $subject->id)>
                                {{ $subject->level->level . ' ' . $subject->name }}
                            </option>
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
                                @selected(old('classroom_id', $attendance->classroom_id) == $classroom->id)>
                                {{ $classroom->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="present" @selected(old('status', $attendance->status) == 'present')>Present</option>
                        <option value="late" @selected(old('status', $attendance->status) == 'late')>Late</option>
                        <option value="absent" @selected(old('status', $attendance->status) == 'absent')>Absent</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="date" class="form-label">Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                        name="date" value="{{ old('date', \Carbon\Carbon::parse($attendance->date)->format('Y-m-d')) }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-12">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note"
                        cols="30" rows="10">{{ old('note',$attendance->note) }}</textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <a href="{{ route('admin.attendances.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Attendance</button>
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
