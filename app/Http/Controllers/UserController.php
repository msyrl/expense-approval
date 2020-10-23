<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('access-users');

        $users = User::query();

        if (request()->filled('q')) {
            $users = $users
                ->where(function ($query) {
                    $q = request()->get('q');

                    return $query->where('username', 'LIKE', "%{$q}%")
                        ->orWhere('email', 'LIKE', "%{$q}%")
                        ->orWhere('name', 'LIKE', "%{$q}%");
                });
        }

        $users = $users->getPaginate();

        return view('users.index', [
            'users' => $users,
            'sortables' => (new User)->getSortables(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-users');

        $roles = Role::orderBy('name', 'asc')->get();

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
        $user = User::create($request->validated());

        if ($request->filled('roles')) {
            $user->roles()->sync($request->roles);
        }

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'Success created new data.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('access-users');

        $user->load(['roles']);

        return view('users.show', [
            'user' => $user,
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
        $this->authorize('edit-users');

        $user->load(['roles']);

        $roles = Role::orderBy('name', 'asc')->get();

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
        $user->update($request->validated());

        if ($request->filled('roles')) {
            $user->roles()->sync($request->roles);
        }

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'Success updated the data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete-users');

        if ($user->roles->count()) {
            return back()->with('error', 'Can\'t delete non-empty data.');
        }

        $user->delete();

        return redirect()
            ->route('users.index', [
                'sort_by' => 'created_at|desc',
            ])
            ->with('success', 'Success deleted the data.');
    }
}
