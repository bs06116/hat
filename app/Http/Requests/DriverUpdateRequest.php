<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverUpdateRequest extends FormRequest
{
  

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         // Validate the incoming request
         return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $this->driver->id, // Ensure unique email except for the current user
            'password'   => 'nullable|min:8|confirmed', // Password is optional
            'departments' => 'required|array', // Departments must be an array
            'departments.*' => 'exists:departments,id', // Each department must exist in the departments table
        ];
    }
   /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'email.required'      => 'Email is required.',
            'email.unique'        => 'This email is already taken.',
            'password.min'        => 'Password must be at least 8 characters.',
            'password.confirmed'  => 'Passwords do not match.',
            'departments.required' => 'You must select at least one department.',
            'departments.*.exists' => 'Selected department is invalid.',
        ];
    }
}
