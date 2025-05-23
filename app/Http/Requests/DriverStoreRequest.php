<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverStoreRequest extends FormRequest
{
  

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'departments' => ['required','array','min:1']
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
            'email.unique' => 'This email has already been taken.',
            // Add other custom messages if needed
        ];
    }
}
