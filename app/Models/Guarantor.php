<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Guarantor extends Pivot
{
    protected $table = 'guarantors';
}
