<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'teacher_id' => 'required|exists:teachers,id',
            'level_id' => 'required|exists:levels,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'required|exists:students,id',
            'marks' => 'required|array',
            'marks.*' => 'required|numeric|min:0|max:100',
            'note' => 'nullable|string|max:500',
        ];
    }
}
