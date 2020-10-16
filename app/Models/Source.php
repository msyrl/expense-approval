<?php

namespace App\Models;

use App\Traits\HasSortables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory, HasSortables;

    protected $guarded = ['id'];

    protected $sortables = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
