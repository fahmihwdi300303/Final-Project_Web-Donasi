<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // ---- METRIC UTAMA ----
        $totalUsers = User::count();

        // Hitung totalDonatur & totalAdmin dengan deteksi skema DB
        if (Schema::hasColumn('users', 'role')) {
            // mode: kolom role ada di tabel users
            $totalDonatur = User::where('role', 'donatur')->count();
            $totalAdmin   = User::where('role', 'admin')->count();
        } elseif (Schema::hasTable('model_has_roles') && Schema::hasTable('roles')) {
            // mode: Spatie Permission (tanpa perlu trait di model untuk sekadar menghitung)
            $totalDonatur = DB::table('model_has_roles')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('roles.name', 'donatur')
                ->count();

            $totalAdmin = DB::table('model_has_roles')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('roles.name', 'admin')
                ->count();
        } else {
            // fallback: donatur = user unik yang pernah berdonasi, admin tidak diketahui
            $totalDonatur = Donation::whereNotNull('user_id')->distinct('user_id')->count('user_id');
            $totalAdmin   = 0;
        }

        $thisMonthAmount = (int) Donation::where('status','verified')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('jumlah');

        $pendingCount  = Donation::where('status','pending')->count();
        $verifiedCount = Donation::where('status','verified')->count();

        // ---- TREN 12 BULAN (verified only) ----
        $from = now()->subMonths(11)->startOfMonth();
        $raw  = Donation::selectRaw("DATE_FORMAT(created_at, '%Y-%m') ym, SUM(jumlah) total")
                ->where('status','verified')
                ->where('created_at','>=',$from)
                ->groupBy('ym')->orderBy('ym')->pluck('total','ym');

        $labels = [];
        $series = [];
        for ($i=11; $i>=0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->translatedFormat('M y');
            $series[] = (int) ($raw[$month] ?? 0);
        }

        // ---- TOP DONATUR (verified) ----
        $topDonors = Donation::select('user_id', DB::raw('SUM(jumlah) as total'))
            ->where('status','verified')->whereNotNull('user_id')
            ->groupBy('user_id')->orderByDesc('total')->take(5)->get()
            ->map(function($row){
                $u = User::find($row->user_id);
                return [
                    'name'  => $u?->name ?? 'Anonim',
                    'email' => $u?->email ?? '-',
                    'total' => (int) $row->total,
                ];
            });

        // ---- AKTIVITAS TERBARU: gabung donasi & user ----
        $recentDonations = Donation::with('user')->latest()->take(5)->get()->map(function($d){
            return [
                'user'   => $d->user?->name ?? 'Anonim',
                'action' => 'Submit Donasi ('.str($d->metode_pembayaran)->upper().')',
                'time'   => $d->created_at,
                'status' => $d->status,
            ];
        });

        $recentUsers = User::latest()->take(5)->get()->map(function($u){
            return [
                'user'   => $u->name,
                'action' => 'Registrasi User',
                'time'   => $u->created_at,
                'status' => 'created',
            ];
        });

        $activities = $recentDonations->merge($recentUsers)
            ->sortByDesc('time')->take(8)->values();

        return view('admin.dashboard', [
            'totalUsers'       => $totalUsers,
            'totalDonatur'     => $totalDonatur,
            'totalAdmin'       => $totalAdmin,
            'thisMonthAmount'  => $thisMonthAmount,
            'pendingCount'     => $pendingCount,
            'verifiedCount'    => $verifiedCount,
            'chart'            => ['labels'=>$labels, 'data'=>$series],
            'topDonors'        => $topDonors,
            'activities'       => $activities,
        ]);
    }
}
