<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile', ['user' => $this->getUser(auth()->user())]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $this->getUser(auth()->user());
        $user->username = $request->username;
        $user->email = $request->email;
        $user->name = $request->name;

        if ($request->has('password')) {
            $user->password = $request->password;
        }

        $user->save();

        request()->session()->flash('alert-success', 'Success updated your profile.');

        return back();
    }

    protected function getUser(User $user)
    {
        return $user;
    }
}
