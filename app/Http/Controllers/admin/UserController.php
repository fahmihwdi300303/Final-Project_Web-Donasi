<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $r)
    {
        $r->validate([
            'name' => 'required|string|max:190',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,donatur',
        ]);

        $user = User::create([
            'name' => $r->name,
            'email' => $r->email,
            'password' => bcrypt($r->password),
        ]);

        if (method_exists($user,'assignRole')) {
            $user->assignRole($r->role);
        }

        return redirect()->route('admin.users.index')->with('success','Pengguna dibuat.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $r, User $user)
    {
        $r->validate([
            'name' => 'required|string|max:190',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,donatur',
        ]);

        $data = [
            'name' => $r->name,
            'email' => $r->email,
        ];
        if ($r->filled('password')) { $data['password'] = bcrypt($r->password); }
        $user->update($data);

        if (method_exists($user,'syncRoles')) {
            $user->syncRoles([$r->role]);
        }

        return redirect()->route('admin.users.index')->with('success','Pengguna diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','Pengguna dihapus.');
    }
}
