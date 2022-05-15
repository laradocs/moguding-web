<?php

namespace App\Http\Requests;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:30',
            'email' => 'required|email|string|max:60',
            'gender' => 'required|integer|in:1,2',
            'password' => 'required|min:5|string|confirmed',
        ];
    }
}
