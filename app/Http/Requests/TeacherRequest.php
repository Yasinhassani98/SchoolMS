<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'nullable|image',
            'name' => 'required|min:3|max:255',
            'gender' => 'required|in:male,female',
            'classroom_ids' => 'nullable|string',
            'subject_ids' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'hiring_date' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'specialization' => 'nullable|max:255',
            'status' => 'required|in:active,inactive',
        ];
    }
}
