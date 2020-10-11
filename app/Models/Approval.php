<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Approval extends Pivot
{
    protected $guarded = ['id'];

    public function setToWaiting()
    {
        return $this->update([
            'approval_status_id' => ApprovalStatus::WAITING,
        ]);
    }

    public function setToApproved()
    {
        return $this->update([
            'approval_status_id' => ApprovalStatus::APPROVED,
        ]);
    }

    public function setToRejected()
    {
        return $this->update([
            'approval_status_id' => ApprovalStatus::REJECTED,
        ]);
    }
}
