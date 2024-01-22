<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAuthStoreRequest extends FormRequest
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
                 'name' => 'required|string',
                 'email' => 'required|email|string|unique:users,email',
                 'password' => 'required|min:8',

             ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'Name is required',
            'email.required'       => 'Email name is required',
            'password.required'    => 'Password name is required',
        ];
    }
}
