<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    // Show the donation form
    public function create()
    {
        return view('donations.create');
    }

    // Store the donation in the database
    public function store(Request $request)
{
    // --- Validation for Everyone ---
    $request->validate([
        'jumlah' => 'required|numeric|min:10000',
        'metode_pembayaran' => 'required|string',
        'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $userId = null;
    $redirectRoute = 'donatur.dashboard';
    $successMessage = 'Donasi Anda telah berhasil diajukan dan sedang menunggu verifikasi.';

    if (Auth::check()) {
        // --- SCENARIO 1: USER IS LOGGED IN ---
        $userId = Auth::id();
    } else {
        // --- SCENARIO 2: USER IS A GUEST ---
        $request->validate([
            'nama_depan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'whatsapp' => 'required|string|max:15',
        ]);

        // Find user by email or create a new one
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->nama_depan,
                'password' => Hash::make(Str::random(12)), // Assign a random password
            ]
        );

        // Assign the 'donatur' role to the new user
        $user->assignRole('donatur');

        $userId = $user->id;
        $redirectRoute = '/'; // Redirect guests to the homepage
        $successMessage = 'Donasi Anda berhasil! Akun donatur sederhana telah kami buatkan untuk Anda.';
    }

    // --- Save the Donation ---
    $path = $request->file('bukti_transfer')->store('bukti_transfers', 'public');

    Donation::create([
        'user_id' => $userId,
        'jumlah' => $request->jumlah,
        'metode_pembayaran' => $request->metode_pembayaran,
        'bukti_transfer' => $path,
        'status' => 'pending',
    ]);

        return redirect($redirectRoute)->with('success', $successMessage);
    }
}
