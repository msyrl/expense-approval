<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
    ];

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getJoinedPermissionNamesAttribute()
    {
        $permissions = $this->permissions();

        if ($permissions->count() < 1) {
            return '-';
        }

        return $permissions
            ->pluck('name')
            ->join(', ');
    }

    public function permissions()
    {
        return $this
            ->belongsToMany(Permission::class)
            ->using(PermissionRole::class);
    }
}
