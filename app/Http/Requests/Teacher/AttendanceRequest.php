<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $classroomId = $this->input('classroom_id');
        $subjectId = $this->input('subject_id');

        $hasClassroom = Auth::user()->teacher->classrooms()
            ->where('classroom_id', $classroomId)
            ->exists();

        $hasSubject = Auth::user()->teacher->subjects()
            ->where('subject_id', $subjectId)
            ->exists();

        return ($hasClassroom && $hasSubject) || Auth::user()->can(['create-attendance','edit-attendance']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
            'note' => 'nullable|string|max:500',
        ];

        // Check if we're handling multiple students or a single student
        if ($this->has('student_ids')) {
            $rules['student_ids'] = 'required|array|min:1';
            $rules['student_ids.*'] = 'required|exists:students,id';
            $rules['attendance_status'] = 'required|array|min:1|size:' . count($this->input('student_ids', []));
            $rules['attendance_status.*'] = 'required|in:present,absent,late';
        } else {
            $rules['student_id'] = 'required|exists:students,id';
            $rules['status'] = 'required|in:present,absent,late';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'classroom_id.required' => 'Please select a classroom',
            'subject_id.required' => 'Please select a subject',
            'date.required' => 'Please select a date',
            'date.before_or_equal' => 'Attendance date cannot be in the future',
            'student_ids.required' => 'No students selected',
            'student_ids.min' => 'At least one student must be selected',
            'attendance_status.required' => 'Attendance status is required for all students',
            'attendance_status.size' => 'Attendance status must be provided for each student',
            'attendance_status.*.in' => 'Attendance status must be present, absent, or late',
            'student_id.required' => 'Please select a student',
            'status.required' => 'Please select an attendance status',
            'status.in' => 'Attendance status must be present, absent, or late',
        ];
    }
}
