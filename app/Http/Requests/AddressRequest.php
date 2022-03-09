<?php

namespace App\Http\Requests;

class AddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'province' => 'required|string|max:10',
            'city' => 'nullable|string|max:10',
            'address' => 'required|max:80',
            'longitude' => 'required|regex:/^\d{3}.\d{5,6}$/',
            'latitude' => 'required|regex:/^\d{2}.\d{5,6}$/',
        ];
    }
}
