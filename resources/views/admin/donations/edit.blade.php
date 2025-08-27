@extends('layouts.app')
@section('title','Edit Donasi')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
<div class="container py-4 theme-blue">
  @include('partials.breadcrumb',['segments'=>['Donasi','Edit']])
  <x-flash/>

  <div class="card">
    <div class="card-body">
      @php $id = data_get($donation,'donation_id', data_get($donation,'id')); @endphp
      <form action="{{ route('admin.donations.update', $id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Donatur</label>
            <input type="text" name="donor_ref" class="form-control"
                   value="{{ data_get($donation,'user.email', data_get($donation,'donor_ref')) }}" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" min="0" class="form-control"
                   value="{{ data_get($donation,'jumlah', data_get($donation,'amount',0)) }}" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Metode</label>
            @php $m = strtolower(data_get($donation,'metode_pembayaran', data_get($donation,'method','qris'))); @endphp
            <select name="metode_pembayaran" class="form-select">
              <option value="qris"     {{ $m==='qris'?'selected':'' }}>QRIS</option>
              <option value="transfer" {{ $m==='transfer'?'selected':'' }}>TRANSFER</option>
              <option value="cash"     {{ $m==='cash'?'selected':'' }}>CASH</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Status</label>
            @php $s = strtolower(data_get($donation,'status','pending')); @endphp
            <select name="status" class="form-select">
              <option value="pending"  {{ $s==='pending'?'selected':'' }}>Pending</option>
              <option value="verified" {{ $s==='verified'?'selected':'' }}>Verified</option>
              <option value="rejected" {{ $s==='rejected'?'selected':'' }}>Rejected</option>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="catatan" class="form-control" rows="3">{{ data_get($donation,'catatan') }}</textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="{{ route('admin.donations.index') }}" class="btn btn-outline">Kembali</a>
          <button class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
