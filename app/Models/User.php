<?php

namespace App\Models;

use App\Traits\HasSortables;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasSortables;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $sortables = [
        'name',
        'username',
        'password',
        'created_at',
        'updated_at',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getJoinedRoleNamesAttribute()
    {
        $roles = $this->roles;

        if ($roles->count() < 1) {
            return '-';
        }

        return $roles
            ->pluck('name')
            ->join(', ');
    }

    public function roles()
    {
        return $this
            ->belongsToMany(Role::class)
            ->using(RoleUser::class);
    }

    public function permissions()
    {
        return $this
            ->roles
            ->map
            ->permissions
            ->flatten()
            ->unique('id');
    }

    public function hasPermissionTo($permission_slug)
    {
        return $this->permissions()->contains('slug', $permission_slug);
    }

    public function expenses()
    {
        return $this
            ->belongsToMany(
                Expense::class,
                'approval',
                'user_id',
                'expense_id'
            )
            ->withPivot([
                'id',
                'approval_status_id',
            ])
            ->withTimestamps();;
    }
}
