<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('access-users'), 401);

        $sortables = [
            'Username A-Z' => 'username|asc',
            'Username Z-A' => 'username|desc',
            'Email A-Z' => 'email|asc',
            'Email Z-A' => 'email|desc',
            'Name A-Z' => 'name|asc',
            'Name Z-A' => 'name|desc',
            'Last Updated A-Z' => 'updated_at|asc',
            'Last Updated Z-A' => 'updated_at|desc',
        ];

        $users = User::query();

        if (request()->filled('q')) {
            $q = request()->get('q');

            $users = $users
                ->where('username', 'LIKE', "%{$q}%")
                ->orWhere('email', 'LIKE', "%{$q}%")
                ->orWhere('name', 'LIKE', "%{$q}%");
        }

        if (request()->filled('sort_by')) {
            if (in_array(request()->get('sort_by'), $sortables)) {
                list($sort, $order) = Str::of(request()->get('sort_by'))->explode('|');

                $users = $users->orderBy($sort, $order);
            }
        }

        $users = $users
            ->paginate(request()->get('per_page', 10))
            ->onEachSide(1)
            ->withQueryString();

        return view('users.index', [
            'users' => $users,
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
        abort_if(Gate::denies('create-users'), 401);

        $roles = Role::all();

        return view('users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = $request->password;
        $user->save();

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        $request->session()->flash('alert-success', 'Success created new data. <a href="' . route('users.show', $user->id) . '">See details.</a>');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('access-users'), 401);

        $roles = Role::all();

        return view('users.show', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_if(Gate::denies('edit-users'), 401);

        $roles = Role::all();

        $user->load(['roles']);

        $roles = $roles->map(function ($role) use ($user) {
            $role->checked = $user->roles->contains('id', $role->id);

            return $role;
        });

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserUpdateRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->username = $request->username;
        $user->email = $request->email;
        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        $request->session()->flash('alert-success', 'Success updated the data. <a href="' . route('users.show', $user->id) . '">See details.</a>');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('delete-users'), 401);

        $user->delete();

        request()->session()->flash('alert-success', 'Success deleted the data.');

        return back();
    }
}
