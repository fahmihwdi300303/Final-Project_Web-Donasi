<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
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

            $user    = Auth::user();

            // Deteksi admin (jalan dengan/ tanpa Spatie)
            $isAdmin = false;
            if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
                $isAdmin = true;
            } elseif (Schema::hasColumn('users','role') && ($user->role ?? null) === 'admin') {
                $isAdmin = true;
            }

            // Arahkan:
            return redirect()->intended(
                $isAdmin ? route('admin.dashboard') : route('donor.money.create')
            );
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
