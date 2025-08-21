<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    // Menampilkan dashboard admin
    public function index()
    {
        // Ambil data statistik (contoh)
        $totalUsers = User::count();
        $totalDonatur = User::where('role_id', 2)->count(); // role_id 2 = Donatur
        $totalAdmin = User::where('role_id', 1)->count(); // role_id 1 = Admin

        return view('admin.dashboard', compact('totalUsers', 'totalDonatur', 'totalAdmin'));
    }
}
