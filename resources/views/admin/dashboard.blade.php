@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<style>
  .stat-card{background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);color:#fff;border-radius:14px;padding:1.25rem;transition:.25s}
  .stat-card:hover{transform:translateY(-4px);box-shadow:0 10px 18px rgba(37,99,235,.2)}
  .stat-value{font-size:2rem;font-weight:800;line-height:1}
  .action-card{background:#fff;border-radius:14px;padding:2rem;text-align:center;box-shadow:0 8px 24px rgba(2,6,23,.06);transition:.25s}
  .action-card:hover{transform:translateY(-4px);box-shadow:0 16px 32px rgba(2,6,23,.1)}
  .badge{border-radius:9999px;padding:.25rem .5rem;font-size:.75rem}
  .badge.pending{background:#FEF3C7;color:#92400E}
  .badge.verified{background:#DCFCE7;color:#166534}
  .badge.updated{background:#DBEAFE;color:#1E40AF}
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto p-6">
  {{-- Header --}}
  <div class="text-center mb-8">
    <h1 class="text-4xl font-extrabold text-gray-800">Selamat Datang, {{ auth()->user()->name }}!</h1>
    <p class="text-gray-500 mt-1">Anda login sebagai Administrator.</p>
  </div>

  {{-- Cards --}}
  <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
    <div class="stat-card">
      <div class="flex items-center gap-3">
        <i class="fa-solid fa-users text-2xl opacity-90"></i>
        <div>
          <div class="stat-value">{{ number_format($totalUsers) }}</div>
          <div class="text-white/80">Total Pengguna</div>
        </div>
      </div>
    </div>
    <div class="stat-card">
      <div class="flex items-center gap-3">
        <i class="fa-solid fa-hand-holding-heart text-2xl opacity-90"></i>
        <div>
          <div class="stat-value">{{ number_format($totalDonatur) }}</div>
          <div class="text-white/80">Total Donatur</div>
        </div>
      </div>
    </div>
    <div class="stat-card">
      <div class="flex items-center gap-3">
        <i class="fa-solid fa-user-shield text-2xl opacity-90"></i>
        <div>
          <div class="stat-value">{{ number_format($totalAdmin) }}</div>
          <div class="text-white/80">Total Admin</div>
        </div>
      </div>
    </div>
    <div class="stat-card">
      <div class="flex items-center gap-3">
        <i class="fa-solid fa-chart-line text-2xl opacity-90"></i>
        <div>
          <div class="stat-value">Rp {{ number_format($thisMonthAmount,0,',','.') }}</div>
          <div class="text-white/80">Donasi Bulan Ini</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Aksi Cepat --}}
  <div class="mt-10">
    <h2 class="text-center font-bold text-gray-700 mb-4">Aksi Cepat</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <a href="{{ route('admin.users.index') }}" class="action-card">
        <i class="fa-solid fa-users text-3xl text-indigo-900 mb-3"></i>
        <div class="text-xl font-semibold text-indigo-900">Manajemen User</div>
      </a>
      <a href="{{ route('admin.donations.index') }}" class="action-card">
        <i class="fa-solid fa-hand-holding-heart text-3xl text-indigo-900 mb-3"></i>
        <div class="text-xl font-semibold text-indigo-900">Manajemen Donasi</div>
      </a>
      <a href="{{ route('admin.reports.donation') }}" class="action-card">
        <i class="fa-solid fa-list text-3xl text-indigo-900 mb-3"></i>
        <div class="text-xl font-semibold text-indigo-900">Laporan Donasi</div>
      </a>
    </div>
  </div>

  {{-- Chart + Top Donatur --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-10">
    <div class="bg-white rounded-2xl p-5 shadow">
      <div class="flex items-center justify-between mb-3">
        <h3 class="font-bold text-gray-800">Tren Donasi (12 bulan, verified)</h3>
        <span class="text-xs text-gray-400">Pending: {{ $pendingCount }} • Verified: {{ $verifiedCount }}</span>
      </div>
      <canvas id="donationChart" height="110"></canvas>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow lg:col-span-2">
      <h3 class="font-bold text-gray-800 mb-3">Top Donatur</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead>
            <tr class="bg-slate-50 text-slate-600">
              <th class="text-left p-3">Nama</th>
              <th class="text-left p-3">Email</th>
              <th class="text-right p-3">Total Donasi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($topDonors as $d)
              <tr class="border-b last:border-0">
                <td class="p-3">{{ $d['name'] }}</td>
                <td class="p-3 text-slate-500">{{ $d['email'] }}</td>
                <td class="p-3 text-right font-semibold">Rp {{ number_format($d['total'],0,',','.') }}</td>
              </tr>
            @empty
              <tr><td colspan="3" class="p-4 text-center text-slate-400">Belum ada donasi terverifikasi.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Aktivitas Terbaru --}}
  <div class="bg-white rounded-2xl p-5 shadow mt-10">
    <h3 class="font-bold text-gray-800 mb-3">Aktivitas Terbaru</h3>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="bg-slate-50 text-slate-600">
            <th class="text-left p-3">User</th>
            <th class="text-left p-3">Aktivitas</th>
            <th class="text-left p-3">Waktu</th>
            <th class="text-left p-3">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($activities as $a)
            <tr class="border-b last:border-0">
              <td class="p-3">{{ $a['user'] }}</td>
              <td class="p-3">{{ $a['action'] }}</td>
              <td class="p-3 text-slate-500">{{ \Carbon\Carbon::parse($a['time'])->diffForHumans() }}</td>
              <td class="p-3">
                @php
                  $s = $a['status'];
                  $class = $s==='verified' ? 'verified' : ($s==='pending' ? 'pending' : 'updated');
                  $label = ucfirst($s);
                @endphp
                <span class="badge {{ $class }}">{{ $label }}</span>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="p-4 text-center text-slate-400">Belum ada aktivitas.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const labels = @json($chart['labels']);
const data   = @json($chart['data']);

const ctx = document.getElementById('donationChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels,
    datasets: [{
      label: 'Nominal (Rp)',
      data,
      fill: true,
      tension: 0.35
    }]
  },
  options: {
    plugins: { legend: { display: false }},
    scales: {
      y: { ticks: { callback: v => 'Rp ' + Number(v).toLocaleString('id-ID') } }
    }
  }
});
</script>
@endpush
