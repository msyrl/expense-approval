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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
