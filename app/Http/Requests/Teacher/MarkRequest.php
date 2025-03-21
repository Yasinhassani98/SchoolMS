<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;


class MarkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Check if we're handling multiple students or a single student
        if ($this->has('student_ids')) {
            [
                'classroom_id' => 'required|exists:classrooms,id',
                'subject_id' => 'required|exists:subjects,id',
                'student_ids' => 'required|array',
                'student_ids.*' => 'required|exists:students,id',
                'mark_values' => 'required|array',
                'mark_values.*' => 'required|numeric|min:0|max:100',
                'note' => 'nullable|string|max:255',
            ];
        } else {
            return [
                'student_id' => ['required', 'integer', 'exists:students,id'],
                'classroom_id' => ['required', 'integer', 'exists:classrooms,id'],
                'subject_id' => ['required', 'integer', 'exists:subjects,id'],
                'mark' => ['required', 'numeric', 'min:0', 'max:100'],
                'note' => ['nullable', 'string', 'max:255'],
            ];
        }
        return [];
    }
}
