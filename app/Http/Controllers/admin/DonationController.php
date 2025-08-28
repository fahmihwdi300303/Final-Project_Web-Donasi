<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DonationController extends Controller
{
    // LIST + filter + pagination
    public function index(Request $request)
    {
        // pastikan di model Donation ada relasi user(): belongsTo(User::class,'user_id')
        $q = Donation::with('user')->orderByDesc('created_at');

        if ($request->filled('status')) {
            $q->where('status', $request->status); // pending/verified/rejected
        }

        if ($request->filled('metode')) {
            $q->where('metode_pembayaran', $request->metode); // qris/transfer/cash/barang
        }

        if ($request->filled('s')) {
            $s = $request->s;
            $q->where(function ($qq) use ($s) {
                $qq->whereHas('user', function ($uu) use ($s) {
                        $uu->where('name', 'like', "%$s%")
                           ->orWhere('email', 'like', "%$s%");
                    })
                   ->orWhere('catatan', 'like', "%$s%");
            });
        }

        $donations = $q->paginate(10)->withQueryString();

        return view('admin.donations.index', compact('donations'));
    }

    // Detail (opsional)
    public function show(Donation $donation)
    {
        $donation->load('user');
        return view('admin.donations.show', compact('donation'));
    }

    // Verifikasi cepat (opsional)
    public function verify(Donation $donation)
    {
        $donation->update(['status' => 'verified']);
        return back()->with('success', 'Donasi diverifikasi.');
    }

    // Hapus (opsional)
    public function destroy(Donation $donation)
    {
        $donation->delete();
        return back()->with('success', 'Donasi dihapus.');
    }

    // === BARU: ubah status cepat via dropdown Aksi
public function setStatus(Request $request, Donation $donation)
{
    $request->validate([
        'status' => 'required|in:pending,verified,rejected',
    ]);

    $donation->update(['status' => $request->status]);

    return back()->with('success', 'Status donasi diperbarui.');
}

}
