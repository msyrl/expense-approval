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
        'category_id',
        'recipient',
        'amount',
        'description',
        'created_at',
        'updated_at',
    ];

    public function getAmountWithSeparatorAttribute()
    {
        return number_format($this->attributes['amount'], 0, ',', '.');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
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
}
