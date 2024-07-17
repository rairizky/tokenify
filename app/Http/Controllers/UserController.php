<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function post_login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (Auth::user()->level->id === 1) {
                return redirect()->route('dashboard.customer.data.index');
            } else {
                return redirect()->route('dashboard.transaction.make.index');
            }
        }

        return back()->withErrors([
            'password' => 'Wrong username or password',
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function post_register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $post = User::create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'level_id' => 2
        ]);

        if ($post) {
            return redirect()->route('auth.register')->with('success', 'Account Created');
        } else {
            return back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
