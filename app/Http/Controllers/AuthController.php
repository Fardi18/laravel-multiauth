<?php

namespace App\Http\Controllers;

use App\Models\Pka;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function userRegister()
    {
        return view('auth.userregister');
    }

    public function pkaRegister()
    {
        return view('auth.pkaregister');
    }

    public function doUserRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:100', 'email', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string'],
            'address' => ['required', 'string', 'max:100'],
        ]);

        // 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        // 
        Auth::login($user);

        return redirect('/login');
    }

    public function doPkaRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:100', 'email', 'unique:' . Pka::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string'],
        ]);

        // 
        $owner = Pka::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
        ]);

        // 
        Auth::login($owner);

        return redirect('/login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin');
        }

        if (Auth::guard('pka')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/pka');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
