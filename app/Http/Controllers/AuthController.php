<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginPage()
    {
        return view('login');
    }

    public function postLogin(PostLoginRequest $request)
    {
        if (!Auth::attempt($this->getCredential($request), $request->remember)) {
            $this->sendErrorFeedback();
        }

        return redirect()->intended('/');
    }

    protected function getCredential(Request $request)
    {
        $usernameKey = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $usernameKey => $request->username,
            'password' => $request->password,
        ];
    }

    protected function sendErrorFeedback()
    {
        throw ValidationException::withMessages([
            'username' => __('auth.failed'),
            'password' => __('auth.failed'),
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            request()->session()->forget('permissions');
            Auth::logout();
        }

        return redirect()->route('login');
    }
}
