<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;

class ReportController extends Controller
{
    public function donation()
    {
        $donations = Donation::with('user')->latest()->get();

        $summary = [
            'total_count'    => $donations->count(),
            'total_amount'   => (int) $donations->sum('jumlah'),
            'verified_count' => $donations->where('status','verified')->count(),
            'pending_count'  => $donations->where('status','pending')->count(),
            'verified_amount'=> (int) $donations->where('status','verified')->sum('jumlah'),
        ];

        return view('admin.reports.donation', [
            'rows'     => $donations,
            'summary'  => $summary,
        ]);
    }

    public function financial()
    {
        // Jika belum ada modul pengeluaran, tampilkan kosong namun halaman tetap hidup
        return view('admin.reports.financial', [
            'finance'      => ['opening_balance'=>0,'income'=>0,'expense'=>0],
            'transactions' => [],
        ]);
    }
}
