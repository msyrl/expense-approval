<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalStatus extends Model
{
    use HasFactory;

    public const WAITING = 1;
    public const APPROVED = 2;
    public const REJECTED = 3;
}
