<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function donation(Request $request)
    {
        $year     = (int) $request->get('year', now()->year);
        $semester = (string) $request->get('semester', (now()->month <= 6 ? '1' : '2')); // '1'|'2'|'all'

        if ($semester === 'all') {
            $start = Carbon::create($year, 1, 1)->startOfDay();
            $end   = Carbon::create($year, 12, 31)->endOfDay();
        } elseif ($semester === '1') {
            $start = Carbon::create($year, 1, 1)->startOfDay();
            $end   = Carbon::create($year, 6, 30)->endOfDay();
        } else {
            $start = Carbon::create($year, 7, 1)->startOfDay();
            $end   = Carbon::create($year, 12, 31)->endOfDay();
        }

        $base = Donation::with('user')
            ->where('status', 'verified')
            ->whereBetween('created_at', [$start, $end]);

        $rows  = (clone $base)->orderByDesc('created_at')->get();
        $total = (clone $base)->sum('jumlah');
        $chart = (clone $base)
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as ym'), DB::raw('SUM(jumlah) as total'))
            ->groupBy('ym')->orderBy('ym')->get();

        return view('admin.reports.donation', compact('rows','total','year','semester','start','end','chart'));
    }
}
