@extends('layouts.app')
@section('title','Laporan Donasi (Admin)')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
@include('partials.donation-style')
<div class="container py-4 theme-blue donation-ui">
  <h1 class="report-title">Laporan Keuangan Dana</h1>
  <p class="report-sub">Donasi Panti Asuhan</p>

  <div class="d-flex justify-content-center mb-3">
    <select class="form-select" style="max-width:220px">
      <option>Per Semester</option>
      <option>Per Bulan</option>
      <option>Per Tahun</option>
    </select>
  </div>

  {{-- Tabel ringkas --}}
  <div class="form-card mb-4">
    <div class="table-responsive">
      <table class="table table-hover align-middle table-admin">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Total Uang</th>
            <th>Ket</th>
          </tr>
        </thead>
        <tbody>
          @forelse(($rows ?? []) as $i => $r)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ data_get($r,'user.name','—') }}</td>
              <td>{{ data_get($r,'created_at') ? \Carbon\Carbon::parse($r->created_at)->format('d/m/Y') : '—' }}</td>
              <td>Rp {{ number_format(data_get($r,'jumlah',0),0,',','.') }}</td>
              <td>{{ ucfirst(data_get($r,'status','pending')) }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted">Total</td></tr>
            <tr><td colspan="5" class="text-center text-muted py-4">Rp 0</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Placeholder Grafik (sesuai UI publik) --}}
  <div class="form-card text-center">
    <h5 class="mb-3">Grafik Donasi</h5>
    <div class="muted">Grafik akan ditampilkan di sini.</div>
  </div>
</div>
@endsection
