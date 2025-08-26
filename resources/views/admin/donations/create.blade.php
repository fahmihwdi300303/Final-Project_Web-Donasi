@extends('layouts.app')
@section('title','Tambah Donasi')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
<div class="container py-4 theme-blue">
  @include('partials.breadcrumb',['segments'=>['Donasi','Tambah']])
  <x-flash/>

  <div class="card">
    <div class="card-body">
      <a href="{{ route('admin.donations.index') }}" class="btn btn-outline">Batal</a>
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Donatur (Email / ID)</label>
            <input type="text" name="donor_ref" class="form-control" placeholder="mis. email@domain.com" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" min="0" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-select" required>
              <option value="qris">QRIS</option>
              <option value="transfer">TRANSFER</option>
              <option value="cash">CASH</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option value="pending">Pending</option>
              <option value="verified">Verified</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label">Catatan (opsional)</label>
            <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan singkat"></textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="{{ route('admin.donations.index') }}" class="btn btn-outline">Batal</a>c
          <button class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
