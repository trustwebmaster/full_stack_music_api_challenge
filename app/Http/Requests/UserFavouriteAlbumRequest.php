<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFavouriteAlbumRequest extends FormRequest
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
            'user_id'     => 'required|exists:users,id',
            'name'        => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
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
            'user_id.required'     => 'User ID is required',
            'user_id.exists'       => 'User does not exist',
            'name.required'        => 'Album name is required',
            'artist_name.required' => 'Artist name is required',
        ];
    }
}
