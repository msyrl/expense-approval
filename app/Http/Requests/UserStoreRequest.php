<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => [
                'required',
                'regex:/^\S*$/u',
                'unique:users,username',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'name' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:6',
            ],
        ];
    }
}
