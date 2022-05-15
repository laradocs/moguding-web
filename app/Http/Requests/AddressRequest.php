<?php

namespace App\Http\Requests;

class AddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'province' => 'required|string|max:10',
            'city' => 'nullable|string|max:10',
            'address' => 'required|string|max:80',
            'longitude' => [
                'required',
                'regex:/^[\-\+]?(0(\.\d{1,10})?|([1-9](\d)?)(\.\d{1,10})?|1[0-7]\d{1}(\.\d{1,10})?|180\.0{1,10})$/',
            ],
            'latitude' => [
                'required',
                'regex:/^[\-\+]?((0|([1-8]\d?))(\.\d{1,10})?|90(\.0{1,10})?)$/',
            ],
        ];
    }

    public function messages()
    {
        return [
            'longitude.regex' => ':attribute 是一个无效的位置。',
            'latitude.regex' => ':attribute 是一个无效的位置。',
        ];
    }
}
