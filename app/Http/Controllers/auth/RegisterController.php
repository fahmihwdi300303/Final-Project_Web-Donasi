<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Schema;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:120',
            'last_name'  => 'nullable|string|max:120',
            'email'      => 'required|email:rfc,dns|unique:users,email',
            'phone'      => 'nullable|string|max:30',
            'password'   => ['required', Password::min(6)],
        ]);

        $user = User::create([
            'name'     => trim(($data['first_name'].' '.($data['last_name'] ?? ''))),
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            // Simpan no. HP hanya kalau kolom ada
            ...(Schema::hasColumn('users','phone') ? ['phone' => $data['phone'] ?? null] : []),
        ]);

        // status/role donatur (tanpa membatasi peran lain)
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('donatur'); // abaikan kalau tidak pakai spatie/permission
        }

        event(new Registered($user));

        // JANGAN langsung login — arahkan ke halaman login
        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil. Silakan login untuk mulai berdonasi.');
    }
}
