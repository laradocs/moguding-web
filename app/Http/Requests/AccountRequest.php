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
        switch ( $this->getMethod() ) {
            case 'POST':
                return [
                    'device' => 'required|string|in:android,ios',
                    'phone' => 'required|integer|digits:11|unique:accounts',
                    'password' => 'required',
                ];
            case 'PUT':
            case 'PATCH':
                $id = $this->route ( 'account' );
                return [
                    'device' => 'required|string|in:android,ios',
                    'phone' => 'required|integer|digits:11|unique:accounts,id,' . $id,
                    'password' => 'required',
                ];
        }
    }
}
