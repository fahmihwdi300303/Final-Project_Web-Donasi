@extends('layouts.app')
@section('title','Laporan Keuangan')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
<div class="container py-4 theme-blue">
  @include('partials.breadcrumb',['segments'=>['Laporan Keuangan']])

  <div class="row g-3 mb-3">
    <div class="col-md-4">
      <div class="card"><div class="card-body">
        <div class="text-muted small">Saldo Awal</div>
        <div class="fs-4 fw-semibold">Rp {{ number_format(data_get($finance,'opening_balance',0),0,',','.') }}</div>
      </div></div>
    </div>
    <div class="col-md-4">
      <div class="card"><div class="card-body">
        <div class="text-muted small">Total Pemasukan</div>
        <div class="fs-4 fw-semibold text-success">+ Rp {{ number_format(data_get($finance,'income',0),0,',','.') }}</div>
      </div></div>
    </div>
    <div class="col-md-4">
      <div class="card"><div class="card-body">
        <div class="text-muted small">Total Pengeluaran</div>
        <div class="fs-4 fw-semibold text-danger">- Rp {{ number_format(data_get($finance,'expense',0),0,',','.') }}</div>
      </div></div>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Rincian Transaksi</h5>
      <div class="d-flex gap-2">
        <input type="month" class="form-control" style="max-width:200px" value="{{ request('period') }}">
        <a class="btn btn-outline" href="#">Export Excel</a>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle table-admin">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Deskripsi</th>
              <th>Kategori</th>
              <th class="text-end">Masuk</th>
              <th class="text-end">Keluar</th>
              <th class="text-end">Saldo</th>
            </tr>
          </thead>
          <tbody>
            @forelse(($transactions ?? []) as $t)
              <tr>
                <td>{{ data_get($t,'date') ? \Carbon\Carbon::parse($t['date'])->format('d/m/Y') : '—' }}</td>
                <td>{{ data_get($t,'desc','—') }}</td>
                <td>{{ data_get($t,'cat','—') }}</td>
                <td class="text-end">{{ data_get($t,'in') ? 'Rp '.number_format($t['in'],0,',','.') : '-' }}</td>
                <td class="text-end">{{ data_get($t,'out') ? 'Rp '.number_format($t['out'],0,',','.') : '-' }}</td>
                <td class="text-end">Rp {{ number_format(data_get($t,'balance',0),0,',','.') }}</td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted py-5">Tidak ada data.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
