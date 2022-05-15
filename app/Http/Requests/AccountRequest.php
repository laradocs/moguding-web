<?php

namespace App\Http\Requests;

class AccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'device' => 'required|string|in:android,ios',
            'phone' => 'required|phone:ZH,CN',
            'password' => 'required|string',
        ];
    }
}
