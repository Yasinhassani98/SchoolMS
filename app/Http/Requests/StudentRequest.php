<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'gender' => 'required|in:male,female',
            'classroom_id' => 'sometimes|required|exists:classrooms,id',
            'parint_id' => 'sometimes|required|exists:parints,id',
            'Phone' => 'nullable|string|max:20',
            'enrollment_date' => 'nullable|date',
            'address' => 'nullable|max:255',
            'date_of_birth' => 'nullable|date',
            'image' => 'nullable|image',
            'status' => 'required|in:active,inactive'
        ];
    }
}
