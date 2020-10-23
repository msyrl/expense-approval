<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('access-roles');

        $roles = Role::query();

        if (request()->filled('q')) {
            $roles = $roles->where(function ($query) {
                $q = request()->get('q');

                return $query->where('slug', 'LIKE', "%{$q}%")
                    ->orWhere('name', 'LIKE', "%{$q}%");
            });
        }

        $roles = $roles->getPaginate();

        return view('roles.index', [
            'roles' => $roles,
            'sortables' => (new Role)->getSortables(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-roles');

        $permissions = Permission::all();

        return view('roles.create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'slug' => $request->slug ?? $request->name,
        ]);

        if ($request->filled('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()
            ->route('roles.show', $role)
            ->with('success', 'Success created new data.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('access-roles');

        $role->load(['permissions']);

        return view('roles.show', [
            'role' => $role,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $this->authorize('edit-roles');

        $role->load(['permissions']);

        $permissions = Permission::all();

        return view('roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleStoreRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleStoreRequest $request, Role $role)
    {
        $role->update([
            'name' => $request->name,
            'slug' => $request->slug ?? $request->name,
        ]);

        if ($request->filled('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()
            ->route('roles.show', $role)
            ->with('success', 'Success updated the data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete-roles');

        if ($role->permissions->count()) {
            return back()->with('error', 'Can\'t delete non-empty data.');
        }

        $role->delete();

        return redirect()
            ->route('roles.index', [
                'sort_by' => 'created_at|desc',
            ])
            ->with('success', 'Success deleted the data.');
    }
}
