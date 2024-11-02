<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantStoreRequest extends FormRequest
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
            'site_name' => ['required', 'string', 'max:255'],
            'domain_name' => [
                'required', 
                'string', 
                'regex:/^[a-zA-Z-]+$/',  // At least 10 characters, only letters and hyphens, no spaces or dots
                'unique:tenants,name'
            ],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            'domain_name.regex' => 'The domain can only contain letters, numbers, and hyphens. No spaces or dots are allowed.',
            'domain_name.required' => 'The domain name is required.',
            'email.unique' => 'This email has already been taken.',
            // Add other custom messages if needed
        ];
    }
}
