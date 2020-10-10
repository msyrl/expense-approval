<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();

        Permission::insert($this->getPermissions());
    }

    protected function truncate()
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        PermissionRole::truncate();
        Schema::enableForeignKeyConstraints();
    }

    protected function getPermissions(): array
    {
        $menus = [
            'Roles',
            'Users',
        ];

        return collect($menus)
            ->map(function ($menu) {
                return [
                    "Access {$menu}",
                    "Create {$menu}",
                    "Edit {$menu}",
                    "Delete {$menu}",
                ];
            })
            ->flatten(1)
            ->map(function ($permission) {
                return [
                    'slug' => Str::slug($permission),
                    'name' => $permission,
                    'created_at' => (string) now(),
                    'updated_at' => (string) now(),
                ];
            })
            ->all();
    }
}
