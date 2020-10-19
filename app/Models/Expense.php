<?php

namespace App\Models;

use App\Traits\HasSortables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory, HasSortables;

    protected $guarded = ['id'];

    protected $sortables = [
        'source_id',
        'category_id',
        'recipient',
        'amount',
        'description',
    ];

    public function getAmountWithSeparatorAttribute()
    {
        return number_format($this->attributes['amount'], 0, ',', '.');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createApprovals(array $userIDs)
    {
        $approvals = collect($userIDs)
            ->map(function ($user_id) {
                return [
                    'user_id' => $user_id,
                    'approval_status_id' => ApprovalStatus::WAITING,
                ];
            })
            ->all();

        return $this->approvals()->createMany($approvals);
    }

    public function hasResponded()
    {
        return $this->approvals->whereIn('approval_status_id', [ApprovalStatus::APPROVED, ApprovalStatus::REJECTED])->count() > 0;
    }
}
