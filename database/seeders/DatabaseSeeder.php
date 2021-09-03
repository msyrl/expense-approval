<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            ApprovalStatusSeeder::class,
        ]);
        $user = $this->createSuperAdminUser();
        $role = $this->createSuperAdminRole();

        $user->roles()->sync($role->id);
        $role->permissions()->sync($this->getPermissionIDs());
    }

    protected function createSuperAdminUser()
    {
        return User::firstOrCreate(
            [
                'username' => 'superadmin',
                'email' => 'superadmin@example.com',
            ],
            [
                'name' => 'Super Admin',
                'password' => 'secret'
            ]
        );
    }

    protected function createSuperAdminRole()
    {
        return Role::firstOrCreate([
            'name' => 'Super Admin',
            'slug' => 'Super Admin',
        ]);
    }

    protected function getPermissionIDs()
    {
        return Permission::all()
            ->pluck('id')
            ->all();
    }
}
