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

    public function users()
    {
        return $this
            ->belongsToMany(
                User::class,
                'approval',
                'expense_id',
                'user_id'
            )
            ->withPivot([
                'id',
                'approval_status_id',
            ])
            ->withTimestamps();
    }

    public function createApprovals(array $userIDs)
    {
        $approvals = collect($userIDs)
            ->map(function ($id) {
                return [
                    $id => [
                        'approval_status_id' => ApprovalStatus::WAITING,
                    ],
                ];
            })
            ->mapWithKeys(function ($id) {
                return $id;
            })
            ->all();

        return $this->users()->attach($approvals);
    }
}
