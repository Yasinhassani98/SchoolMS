<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParintRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'image' => 'nullable|image',
        ];
    }
}
