<?php

namespace App\Http\Requests;

class TaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_id' => 'required|integer',
            'address_id' => 'required|integer',
            'type' => 'required|string|in:START,END',
            'run_role' => 'required|string|in:daily',
            'run_time' => 'required|string|regex:/^\d{2}:\d{2}$/',
            'status' => 'required|integer|between:0,1',
        ];
    }
}
