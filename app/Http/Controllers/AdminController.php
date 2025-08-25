<?php

// Lokasi: app/Http/Controllers/AdminController.php

namespace App\Http\Controllers; // Namespace diperbaiki

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller // Nama Class diperbaiki
{
    /**
     * Menampilkan dashboard admin.
     */
    public function dashboard()
    {
        // Pastikan hanya admin yang bisa mengakses, meskipun sudah ada middleware.
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak punya akses.');
        }

        // Ambil data statistik
        $totalUsers = User::count();
        // Anda menggunakan Spatie/Permission, jadi gunakan relasi roles() untuk menghitung
        $totalDonatur = User::role('donatur')->count();
        $totalAdmin = User::role('admin')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalDonatur', 'totalAdmin'));
    }
}
