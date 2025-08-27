<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Donation;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers   = class_exists(User::class) ? User::count() : 0;
        $totalDonatur = (class_exists(User::class) && method_exists(new User,'role')) ? User::role('donatur')->count() : 0;
        $totalAdmin   = (class_exists(User::class) && method_exists(new User,'role')) ? User::role('admin')->count()   : 0;

        return view('admin.dashboard', [
            'totalUsers'   => $totalUsers,
            'totalDonatur' => $totalDonatur,
            'totalAdmin'   => $totalAdmin,
        ]);
    }
}
