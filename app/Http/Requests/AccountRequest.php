<?php

namespace App\Http\Requests;

class AccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device' => 'required|string|in:android,ios',
            'phone' => 'required|integer|digits:11',
            'password' => 'required',
        ];
    }
}
