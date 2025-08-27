@extends('layouts.app')
@section('title','Tambah Donasi Barang (Admin)')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
@include('partials.donation-style')
<div class="container py-4 theme-blue donation-ui">
  <h1 class="page-title">Donasi Barang</h1>
  <p class="sub-title">Bantu anak-anak yatim dengan donasi barang yang layak pakai</p>

  <div class="row g-4">
    {{-- KIRI: Form --}}
    <div class="col-lg-7">
      <div class="form-card">
        <form action="{{ route('admin.donations.store') }}" method="POST">
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
              <label class="form-label">Jenis Barang *</label>
              <select name="jenis_barang" class="form-select" required>
                <option value="pakaian">Pakaian</option>
                <option value="alat_tulis">Alat Tulis</option>
                <option value="elektronik">Elektronik</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Jumlah *</label>
              <input type="number" name="qty" min="1" class="form-control" required>
            </div>

            {{-- mapping ke tabel donations tetap via catatan/metode = barang --}}
            <input type="hidden" name="metode_pembayaran" value="barang">

            <div class="col-12">
              <label class="form-label">Catatan</label>
              <textarea name="catatan" rows="3" class="form-control" placeholder="Kondisi/merk/ukuran, dll"></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label">Status</label>
              <input type="hidden" name="status" value="verified">
                <option value="pending">Pending</option>
                <option value="verified">Verified</option>
                <option value="rejected">Rejected</option>
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.donations.index') }}" class="btn btn-outline">Batal</a>
            <button class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    {{-- KANAN: Info seperti di publik --}}
    <div class="col-lg-5">
      <div class="info-card">
        <div class="method-title mb-2">Informasi Donasi Barang</div>
        <ul class="list-unstyled text-success mb-3" style="margin-left:.5rem">
          <li>✔ Pakaian layak pakai (anak & dewasa)</li>
          <li>✔ Buku & perlengkapan sekolah</li>
          <li>✔ Mainan edukatif</li>
          <li>✔ Makanan/minuman dalam kemasan</li>
          <li>✔ Elektronik yang masih berfungsi</li>
        </ul>
        <div class="muted">Syarat & Ketentuan:</div>
        <ul class="text-muted mt-2 mb-0">
          <li>Barang bersih dan tidak robek.</li>
          <li>Tidak kedaluwarsa untuk makanan/minuman.</li>
          <li>Admin akan menghubungi untuk konfirmasi.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
