<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => [
                'required',
                'regex:/^\S*$/u',
                'unique:users,username,' . auth()->id(),
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . auth()->id(),
            ],
            'name' => [
                'required',
                'string',
            ],
        ];

        if ($this->filled('password')) {
            $rules['old_password'] = [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('Old password is invalid.');
                    }
                },
            ];

            $rules['password'] = [
                'required',
                'confirmed',
                'string',
                'min:6',
            ];
        }

        return $rules;
    }
}
