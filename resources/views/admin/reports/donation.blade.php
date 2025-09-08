@extends('layouts.app')

@section('title','Laporan Donasi')

@php
  use Illuminate\Support\Str;
  use Carbon\Carbon;

  $rupiah = fn($n) => 'Rp '.number_format((int)$n,0,',','.');
  // siapkan label & dataset grafik (per bulan)
  $labels = $chart->pluck('ym')->map(function($ym){
      try {
          return Carbon::createFromFormat('Y-m', $ym)->translatedFormat('M Y');
      } catch (\Throwable $e) {
          return $ym;
      }
  });

  $dataset = $chart->pluck('total');
@endphp

@section('content')
<div class="container py-4">

  {{-- breadcrumb (tidak error meski file tidak ada) --}}
  @includeIf('partials.navbar.breadcrumb', ['segments' => ['Laporan','Donasi']])

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 m-0">Laporan Keuangan Dana</h1>
    <span class="text-muted">Donasi Panti Asuhan</span>
  </div>

  {{-- Filter --}}
  <form method="GET" class="row g-2 align-items-end mb-4">
    <div class="col-auto">
      <label class="form-label small mb-1">Semester</label>
      <select name="semester" class="form-select">
        <option value="1"  {{ $semester==='1'  ? 'selected':'' }}>Semester 1</option>
        <option value="2"  {{ $semester==='2'  ? 'selected':'' }}>Semester 2</option>
        <option value="all"{{ $semester==='all'? 'selected':'' }}>Semua</option>
      </select>
    </div>
    <div class="col-auto">
      <label class="form-label small mb-1">Tahun</label>
      <select name="year" class="form-select">
        @for($y = now()->year; $y >= now()->year-5; $y--)
          <option value="{{ $y }}" {{ (int)$year===$y ? 'selected':'' }}>{{ $y }}</option>
        @endfor
      </select>
    </div>
    <div class="col-auto">
      <button class="btn btn-primary">Terapkan</button>
    </div>
    <div class="col-12">
      <small class="text-muted">
        Periode: {{ $start->translatedFormat('d M Y') }} — {{ $end->translatedFormat('d M Y') }}
      </small>
    </div>
  </form>

  {{-- Ringkasan total --}}
  <div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
      <div>
        <div class="fw-semibold">Total Uang</div>
        <div class="fs-4">{{ $rupiah($total) }}</div>
      </div>
      <div class="text-end">
        <div class="text-muted small">Transaksi terverifikasi dalam periode</div>
        <div class="small">{{ $rows->count() }} transaksi</div>
      </div>
    </div>
  </div>

  {{-- Tabel rincian --}}
  <div class="card mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th style="width:60px">No</th>
              <th>Nama</th>
              <th style="width:160px">Tanggal</th>
              <th style="width:160px" class="text-end">Total Uang</th>
              <th style="width:140px">Metode</th>
              <th style="width:120px">Status</th>
            </tr>
          </thead>
          <tbody>
          @forelse($rows as $i => $d)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ optional($d->user)->name ?? '—' }}</td>
              <td>{{ $d->created_at?->translatedFormat('d M Y') }}</td>
              <td class="text-end">{{ $rupiah($d->jumlah) }}</td>
              <td class="text-uppercase">{{ $d->metode_pembayaran }}</td>
              <td>
                <span class="badge {{ $d->status==='verified' ? 'bg-success' : ($d->status==='rejected'?'bg-danger':'bg-warning text-dark') }}">
                  {{ Str::ucfirst($d->status) }}
                </span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi pada periode ini.</td>
            </tr>
          @endforelse
          </tbody>
          @if($rows->count())
          <tfoot>
            <tr class="fw-semibold">
              <td colspan="3" class="text-end">Total</td>
              <td class="text-end">{{ $rupiah($total) }}</td>
              <td colspan="2"></td>
            </tr>
          </tfoot>
          @endif
        </table>
      </div>
    </div>
  </div>

  {{-- Grafik --}}
  <div class="card">
    <div class="card-body">
      <h5 class="card-title mb-3">Grafik Donasi</h5>
      @if($dataset->sum() > 0)
        <canvas id="donationChart" height="90"></canvas>
      @else
        <div class="text-center text-muted py-4">Grafik akan ditampilkan di sini.</div>
      @endif
    </div>
  </div>
</div>
@endsection

@push('scripts')
  {{-- Chart.js CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    (function(){
      const labels = @json($labels->values());
      const data   = @json($dataset->values());

      if (document.getElementById('donationChart') && data.reduce((a,b)=>a+b,0) > 0) {
        const ctx = document.getElementById('donationChart').getContext('2d');
        new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [{
              label: 'Total Donasi (Rp)',
              data: data,
              tension: 0.35,
              fill: true,
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { display: true }
            },
            scales: {
              y: {
                ticks: {
                  callback: function(v){ try { return new Intl.NumberFormat('id-ID').format(v); } catch(e){ return v } }
                }
              }
            }
          }
        });
      }
    })();
  </script>
@endpush
