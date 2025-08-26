@extends('layouts.app')
@section('title','Detail Donasi')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
<div class="container py-4 theme-blue">
  @include('partials.breadcrumb',['segments'=>['Donasi','Detail']])

  @php
    $id     = data_get($donation,'donation_id', data_get($donation,'id'));
    $nama   = data_get($donation,'user.name','—');
    $jumlah = data_get($donation,'jumlah', data_get($donation,'amount',0));
    $metode = strtoupper(data_get($donation,'metode_pembayaran', data_get($donation,'method','-')));
    $status = strtolower(data_get($donation,'status','pending'));
  @endphp

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="mb-3">Informasi Donasi</h5>
          <div class="row mb-2">
            <div class="col-sm-4 text-muted">Donatur</div>
            <div class="col-sm-8">{{ $nama }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-4 text-muted">Jumlah</div>
            <div class="col-sm-8">Rp {{ number_format($jumlah,0,',','.') }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-4 text-muted">Metode</div>
            <div class="col-sm-8">{{ $metode }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-4 text-muted">Status</div>
            <div class="col-sm-8">
              <span class="badge bg-{{ $status==='verified'?'success':($status==='pending'?'warning text-dark':'danger') }}">
                {{ ucfirst($status) }}
              </span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-4 text-muted">Tanggal</div>
            <div class="col-sm-8">{{ data_get($donation,'created_at') ? \Carbon\Carbon::parse($donation->created_at)->format('d/m/Y H:i') : '—' }}</div>
          </div>
          <div class="row">
            <div class="col-sm-4 text-muted">Catatan</div>
            <div class="col-sm-8">{{ data_get($donation,'catatan','—') }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-body d-flex flex-column gap-2">
          <a href="{{ Route::has('admin.donations.edit') ? route('admin.donations.edit',$id) : url('/admin/donations/'.$id.'/edit') }}"
             class="btn btn-outline-secondary"><i class="fas fa-pen me-1"></i> Edit</a>
          <form action="{{ Route::has('admin.donations.destroy') ? route('admin.donations.destroy',$id) : url('/admin/donations/'.$id) }}"
                method="POST">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger" onclick="return confirm('Hapus donasi ini?')">
              <i class="fas fa-trash me-1"></i> Hapus
            </button>
          </form>
          <a href="{{ Route::has('admin.donations.index') ? route('admin.donations.index') : url('/admin/donations') }}"
             class="btn btn-primary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
