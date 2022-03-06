<?php

namespace App\Http\Requests;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:30|unique:users',
            'email' => 'required|email|max:60|unique:users',
            'gender' => 'required|integer|between:0,1',
            'password' => 'required|string|min:5|confirmed',
        ];
    }
}
