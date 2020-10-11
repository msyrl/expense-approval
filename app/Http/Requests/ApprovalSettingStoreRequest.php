<?php

namespace App\Http\Requests;

use App\Models\ApprovalSetting;
use App\Rules\DuplicateRange;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ApprovalSettingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::any(['create-approval-settings', 'edit-approval-settings']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $duplicateRangeRule = new DuplicateRange(
            $this->get('from_amount'),
            $this->get('to_amount'),
            ApprovalSetting::query(),
            'from_amount',
            'to_amount',
            $this->approval_setting ? $this->approval_setting->id : null
        );

        return [
            'from_amount' => [
                'required',
                'numeric',
                $duplicateRangeRule,
            ],
            'to_amount' => [
                'required',
                'numeric',
                'min:' . $this->get('from_amount'),
                $duplicateRangeRule,
            ],
            'users' => [
                'required',
                'array',
            ],
            'users.*' => [
                'exists:users,id',
            ],
        ];
    }
}
