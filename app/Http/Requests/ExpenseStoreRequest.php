<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ExpenseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::any(['create-expenses', 'edit-expenses']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'recipient' => [
                'required',
                'string',
            ],
            'amount' => [
                'required',
                'numeric',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ];
    }
}
