<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // UI-mu sudah ada
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember', false);

        if (Auth::attempt($request->only('email','password'), $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
                return redirect()->intended(route('admin.dashboard'));
            }

            // kalau kamu memang pakai role donatur
            if (method_exists($user, 'hasRole') && $user->hasRole('donatur')) {
                // arahkan ke halaman yang ADA
                return redirect()->intended('/dashboard'); // atau '/donasi'
            }

            // fallback aman ke halaman umum yang ADA
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Kredensial tidak cocok.'])->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
