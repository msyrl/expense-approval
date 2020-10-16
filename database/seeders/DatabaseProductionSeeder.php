<?php

namespace Database\Seeders;

use App\Models\Approval;
use App\Models\ApprovalSetting;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Guarantor;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->truncate();

        $this->call([
            PermissionsTableSeeder::class,
            ApprovalStatusSeeder::class,
        ]);
        $user = $this->createSuperAdminUser();
        $role = $this->createSuperAdminRole();

        $user->roles()->sync($role->id);
        $role->permissions()->sync($this->getPermissionIDs());

        Schema::enableForeignKeyConstraints();
    }

    protected function truncate()
    {
        RoleUser::truncate();
        PermissionRole::truncate();
        User::truncate();
        Role::truncate();
        Permission::truncate();
        Source::truncate();
        Category::truncate();
        Expense::truncate();
        Guarantor::truncate();
        ApprovalSetting::truncate();
        Approval::truncate();
    }

    protected function createSuperAdminUser()
    {
        $user = new User;
        $user->name = 'Super Admin';
        $user->username = 'superadmin';
        $user->email = 'superadmin@example.com';
        $user->password = '123123';
        $user->save();

        return $user;
    }

    protected function createSuperAdminRole()
    {
        $role = new Role;
        $role->name = 'Super Admin';
        $role->slug = $role->name;
        $role->save();

        return $role;
    }

    protected function getPermissionIDs()
    {
        return Permission::all()
            ->pluck('id')
            ->all();
    }
}
