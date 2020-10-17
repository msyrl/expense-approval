<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\ApprovalStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApprovalController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('access-approvals'), 401);

        $collection = Approval::with(['user', 'expense', 'approval_status'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(request()->get('per_page', 10));

        return view('approvals.index', [
            'collection' => $collection,
        ]);
    }

    public function show(Approval $approval)
    {
        abort_if($approval->user_id != auth()->id(), 401);

        $approval->load(['expense', 'approval_status']);

        return view('approvals.show', [
            'approval' => $approval,
        ]);
    }

    public function update(Request $request, Approval $approval)
    {
        abort_if($approval->user_id != auth()->id(), 401);

        $this->validate($request, [
            'approval_status_id' => [
                'required',
                'exists:approval_statuses,id',
            ],
            'note' => [
                'nullable',
                'required_if:approval_status_id,' . ApprovalStatus::REJECTED,
            ],
        ], [
            'note.required_if' => 'The note field is required when approval status id is rejected.',
        ]);

        switch ($request->approval_status_id) {
            case ApprovalStatus::APPROVED:
                $approval->setToApproved();
                break;

            case ApprovalStatus::REJECTED:
                $approval->setToRejected();
                break;
        }

        $request->session()->flash('alert-success', 'Success updated the data. <a href="' . route('approvals.show', $approval->id) . '">See details.</a>');

        return back();
    }
}
