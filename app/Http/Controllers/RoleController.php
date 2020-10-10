<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('access-roles'), 401);

        $sortables = [
            'Slug A-Z' => 'slug|asc',
            'Slug Z-A' => 'slug|desc',
            'Name A-Z' => 'name|asc',
            'Name Z-A' => 'name|desc',
            'Last Updated A-Z' => 'updated_at|asc',
            'Last Updated Z-A' => 'updated_at|desc',
        ];

        $roles = Role::query();

        if (request()->filled('q')) {
            $q = request()->get('q');

            $roles = $roles
                ->where('slug', 'LIKE', "%{$q}%")
                ->orWhere('name', 'LIKE', "%{$q}%");
        }

        if (request()->filled('sort_by')) {
            if (in_array(request()->get('sort_by'), $sortables)) {
                list($sort, $order) = Str::of(request()->get('sort_by'))->explode('|');

                $roles = $roles->orderBy($sort, $order);
            }
        }

        $roles = $roles
            ->paginate(request()->get('per_page', 10))
            ->onEachSide(1)
            ->withQueryString();

        return view('roles.index', [
            'roles' => $roles,
            'sortables' => $sortables,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('create-roles'), 401);

        $permissions = Permission::all();

        return view('roles.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $role = new Role;
        $role->name = $request->name;
        $role->slug = $request->slug ?? $request->name;
        $role->save();

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        $request->session()->flash('alert-success', 'Success created new data. <a href="' . route('roles.show', $role->id) . '">See details.</a>');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        abort_if(Gate::denies('access-roles'), 401);

        $role->load(['permissions']);

        return view('roles.show', ['role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        abort_if(Gate::denies('edit-roles'), 401);

        $permissions = Permission::all();

        $role->load(['permissions']);

        $permissions = $permissions->map(function ($permission) use ($role) {
            $permission->checked = $role->permissions->contains('id', $permission->id);

            return $permission;
        });

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
        $role->name = $request->name;
        $role->slug = $request->slug ?? $request->name;
        $role->save();

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        $request->session()->flash('alert-success', 'Success updated the data. <a href="' . route('roles.show', $role->id) . '">See details.</a>');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        abort_if(Gate::denies('delete-roles'), 401);

        $role->delete();

        request()->session()->flash('alert-success', 'Success deleted the data.');

        return back();
    }
}
