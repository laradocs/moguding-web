<?php

namespace App\Http\Requests;

class TaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account' => 'required|integer',
            'address' => 'required|integer',
            'type' => 'required|string|in:START,END',
            'run_role' => 'required|string|in:daily',
            'run_time' => [
                'required',
                'regex:/^\d{2}:\d{2}$/',
            ],
            'status' => 'required|integer|in:0,1',
        ];
    }

    public function attributes()
    {
        return [
            'account' => '打卡账号',
            'address' => '打卡地址',
        ];
    }

    public function messages()
    {
        return [
            'run_time.regex' => ':attribute 格式不正确。',
        ];
    }
}
