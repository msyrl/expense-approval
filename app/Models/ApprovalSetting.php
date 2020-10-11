<?php

namespace App\Models;

use App\Traits\HasSortables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalSetting extends Model
{
    use HasFactory, HasSortables;

    protected $guarded = ['id'];

    protected $sortables = [
        'from_amount',
        'to_amount',
    ];

    public function getFromAmountWithSeparatorAttribute()
    {
        return number_format($this->attributes['from_amount'], 0, ',', '.');
    }

    public function getToAmountWithSeparatorAttribute()
    {
        return number_format($this->attributes['to_amount'], 0, ',', '.');
    }

    public function guarantors()
    {
        return $this
            ->belongsToMany(
                User::class,
                'guarantors',
                'approval_setting_id',
                'user_id'
            )
            ->using(Guarantor::class);
    }
}
