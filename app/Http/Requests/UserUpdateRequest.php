<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('edit-users');
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
                'unique:users,username,' . $this->user->id,
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->user->id,
            ],
            'name' => [
                'required',
                'string',
            ],
        ];

        if ($this->filled('password')) {
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
