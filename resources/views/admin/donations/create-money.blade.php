@extends('layouts.app')
@section('title','Tambah Donasi Uang (Admin)')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
@include('partials.donation-style')
<div class="container py-4 theme-blue donation-ui">
  <h1 class="page-title">Donasi Uang</h1>
  <p class="sub-title">Bantu anak-anak yatim dengan donasi uang Anda</p>

  <div class="row g-4">
    {{-- KIRI: Form --}}
    <div class="col-lg-7">
      <div class="form-card">
        <form action="{{ Route::has('admin.donations.store') ? route('admin.donations.store') : url('/admin/donations') }}" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nama Depan *</label>
              <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nama Belakang *</label>
              <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label class="form-label">Email *</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label class="form-label">Nomor WhatsApp *</label>
              <input type="text" name="whatsapp" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Jumlah Donasi (Rp) *</label>
              <input type="number" name="jumlah" min="1000" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Metode Pembayaran *</label>
              <select name="metode_pembayaran" class="form-select" required>
                <option value="qris">QRIS</option>
                <option value="transfer">Transfer</option>
                <option value="cash">Cash</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="pending">Pending</option>
                <option value="verified">Verified</option>
                <option value="rejected">Rejected</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Catatan</label>
              <textarea name="catatan" rows="3" class="form-control" placeholder="Catatan (opsional)"></textarea>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ Route::has('admin.donations.index') ? route('admin.donations.index') : url('/admin/donations') }}" class="btn btn-outline">Batal</a>
            <button class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    {{-- KANAN: UI metode (meniru publik) --}}
    <div class="col-lg-5">
      <div class="info-card">
        <div class="method-title">Pilih Metode Pembayaran</div>
        <div class="qr-box mb-3">
          <div class="fw-semibold mb-1">QRIS</div>
          <small class="muted">QR Code Standar Pembayaran Nasional</small>
        </div>

        <div class="muted fw-semibold mb-2">Transfer Bank</div>
        <div class="bank-grid">
          <div class="form-card p-2 text-center">BCA</div>
          <div class="form-card p-2 text-center">BRI</div>
          <div class="form-card p-2 text-center">Mandiri</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
