<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $r)
{
    $rules = [
        'email'    => ['required','email','max:190','unique:users,email'],
        'password' => ['required','min:6'],
    ];
    if ($r->filled('password_confirmation')) {
        $rules['password'][] = 'confirmed';
    }
    $r->validate($rules);

    $name = trim(($r->input('name') ?: '')
            ?: (($r->input('first_name').' '.$r->input('last_name'))));
    if ($name === '') { $name = $r->email; }

    $data = [
        'name'     => $name,
        'email'    => $r->email,
        'password' => \Illuminate\Support\Facades\Hash::make($r->password),
    ];

    if (\Illuminate\Support\Facades\Schema::hasColumn('users','phone') && $r->filled('phone')) {
        $data['phone'] = $r->phone;
    }
    if (\Illuminate\Support\Facades\Schema::hasColumn('users','role')) {
        $data['role'] = 'donatur';
    }

    $user = \App\Models\User::create($data);

    // Kalau ada Spatie/Permission, tetap assign role donatur
    if (method_exists($user, 'assignRole')) {
        $user->assignRole('donatur');
    }

    // JANGAN auto-login → arahkan ke halaman login
    return redirect()->route('login')
        ->with('success', 'Akun berhasil dibuat. Silakan masuk.');
    }
}
