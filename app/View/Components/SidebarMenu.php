<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class SidebarMenu extends Component
{
    public $menus;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menus = $this->getAvailableMenus(auth()->user());
    }

    protected function getMenus()
    {
        return collect([
            (object) [
                'permission_slug' => 'access-expenses',
                'label' => 'Expenses',
                'icon' => 'fas fa-dollar-sign',
                'url' => route('expenses.index'),
            ],
            (object) [
                'permission_slug' => 'access-categories',
                'label' => 'Categories',
                'icon' => 'fas fa-tag',
                'url' => route('categories.index'),
            ],
            (object) [
                'permission_slug' => 'access-users',
                'label' => 'Users',
                'icon' => 'fas fa-users',
                'url' => route('users.index'),
            ],
            (object) [
                'permission_slug' => 'access-roles',
                'label' => 'Roles',
                'icon' => 'fas fa-user-lock',
                'url' => route('roles.index'),
            ],
        ]);
    }

    protected function staticMenus()
    {
        return collect([
            (object) [
                'label' => 'My Profile',
                'icon' => 'fas fa-user-circle',
                'url' => route('profile.index'),
            ],
        ]);
    }

    protected function getAvailableMenus(User $user)
    {
        $userPermissionSlugs = $user->permissions()->pluck('slug');

        return $this->getMenus()
            ->filter(function ($menu) use ($userPermissionSlugs) {
                return $userPermissionSlugs->contains($menu->permission_slug);
            })
            ->merge($this->staticMenus()->flatten());
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.sidebar-menu');
    }
}
