<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('user')->latest()->get();
        return view('admin.donations.index', compact('donations'));
    }

    // Halaman create bawaan (opsional)
    public function create()
    {
        return view('admin.donations.create');
    }

    // Halaman create gaya publik: Donasi Uang
    public function createMoney()
    {
        return view('admin.donations.create-money');
    }

    // Halaman create gaya publik: Donasi Barang
    public function createGoods()
    {
        return view('admin.donations.create-goods');
    }

    public function store(Request $r)
    {
        // Support form "uang" dan "barang" (UI publik)
        $r->validate([
            'metode_pembayaran' => 'required|string',    // qris/transfer/cash/barang
            'status'            => 'nullable|string|in:pending,verified,rejected',
            'jumlah'            => 'nullable|numeric|min:0',
            'email'             => 'nullable|email',
        ]);

        DB::transaction(function () use ($r) {

            // Cari/buat user donatur bila email diisi
            $userId = null;
            if ($r->filled('email')) {
                $user = User::firstOrCreate(
                    ['email' => $r->email],
                    ['name' => trim(($r->first_name.' '.$r->last_name) ?: $r->email),
                     'password' => bcrypt(str()->random(12))]
                );
                // Jika pakai Spatie Permission:
                if (method_exists($user, 'assignRole')) { $user->assignRole('donatur'); }
                $userId = $user->id;
            }

            Donation::create([
                'user_id'            => $userId,
                'jumlah'             => $r->input('jumlah', 0),
                'metode_pembayaran'  => $r->metode_pembayaran, // qris/transfer/cash/barang
                'status'             => $r->input('status','pending'),
                'catatan'            => $r->input('catatan'),
            ]);
        });

        return redirect()->route('admin.donations.index')->with('success','Donasi berhasil disimpan.');
    }

    public function show($id)
    {
        $donation = Donation::with('user')
            ->where('donation_id',$id)->orWhere('id',$id)->firstOrFail();

        return view('admin.donations.show', compact('donation'));
    }

    public function edit($id)
    {
        $donation = Donation::where('donation_id',$id)->orWhere('id',$id)->firstOrFail();
        return view('admin.donations.edit', compact('donation'));
    }

    public function update(Request $r, $id)
    {
        $r->validate([
            'jumlah' => 'nullable|numeric|min:0',
            'metode_pembayaran' => 'required|string',
            'status' => 'required|in:pending,verified,rejected',
        ]);

        $donation = Donation::where('donation_id',$id)->orWhere('id',$id)->firstOrFail();
        $donation->update([
            'jumlah' => $r->input('jumlah', 0),
            'metode_pembayaran' => $r->metode_pembayaran,
            'status' => $r->status,
            'catatan' => $r->input('catatan'),
        ]);

        return redirect()->route('admin.donations.index')->with('success','Donasi diperbarui.');
    }

    public function destroy($id)
    {
        $donation = Donation::where('donation_id',$id)->orWhere('id',$id)->firstOrFail();
        $donation->delete();

        return redirect()->route('admin.donations.index')->with('success','Donasi dihapus.');
    }
}
