<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List & filter sederhana
    public function index(Request $request)
    {
        $q = User::query()->latest();

        // optional: pencarian nama/email
        if ($request->filled('s')) {
            $s = $request->s;
            $q->where(function ($qq) use ($s) {
                $qq->where('name', 'like', "%$s%")
                   ->orWhere('email', 'like', "%$s%");
            });
        }

        $users = $q->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }
}
