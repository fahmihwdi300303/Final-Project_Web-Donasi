<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    /* ---------- UI ---------- */
    public function createMoney()  { return view('donasi.form-uang');   }
    public function createGoods()  { return view('donasi.form-barang'); }
    public function createProof()  { return view('donasi.validasipage'); }
    public function history()
    {
        // Boleh dipakai/abaikan di blade; aman walau tak dipakai
        $myDonations = Donation::where('user_id', auth()->id())->latest()->get();
        return view('donasi.laporanpage', compact('myDonations'));
    }

    /* ---------- Store Donasi Uang ---------- */
    public function storeMoney(Request $r)
    {
        // Normalisasi angka: terima 3.000.000 / 3,000,000 / 3000000
        $raw = preg_replace('/[^\d]/', '', (string) $r->input('jumlah','0'));
        $jumlah = $raw === '' ? 0 : (int) $raw;

        $r->validate([
            'metode_pembayaran' => 'required|string',        // qris/transfer/cash/ewallet
            'jumlah'            => 'nullable',
            'catatan'           => 'nullable|string',
        ]);

        Donation::create([
            'user_id'           => auth()->id(),
            'jumlah'            => $jumlah,
            'metode_pembayaran' => $r->metode_pembayaran,
            'bukti_transfer'    => null,
            'status'            => 'pending',               // admin yang verifikasi
        ]);

        return back()->with('success','Donasi uang terkirim. Menunggu verifikasi admin.');
    }

    /* ---------- Store Donasi Barang ---------- */
    public function storeGoods(Request $r)
    {
        // Silakan tambah field barang/qty kalau tabel sudah ada
        Donation::create([
            'user_id'           => auth()->id(),
            'jumlah'            => 0,
            'metode_pembayaran' => 'barang',
            'bukti_transfer'    => null,
            'status'            => 'pending',
        ]);

        return back()->with('success','Donasi barang terkirim. Menunggu verifikasi admin.');
    }

    /* ---------- Upload Bukti/Validasi ---------- */
    public function storeProof(Request $r)
    {
        $r->validate([
            'bukti' => 'required|image|max:2048', // jpg/png/webp; sesuaikan
        ]);

        $path = $r->file('bukti')->store('bukti', 'public');

        // Kalau tabel donations punya kolom bukti_transfer → simpan di salah satu donasi pending user
        if (Schema::hasColumn('donations', 'bukti_transfer')) {
            $donation = Donation::where('user_id', auth()->id())
                        ->where('status','pending')->latest()->first();
            if ($donation) {
                $donation->update(['bukti_transfer' => $path]);
            }
        }
        // (opsional) kalau ada tabel donation_verifications bisa insert juga di sana

        return back()->with('success','Bukti donasi terkirim.');
    }
}
