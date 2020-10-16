<?php

namespace App\Models;

use App\Traits\HasSortables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasSortables;

    protected $guarded = ['id'];

    protected $sortables = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function expense()
    {
        return $this->hasMany(Expense::class);
    }
}
