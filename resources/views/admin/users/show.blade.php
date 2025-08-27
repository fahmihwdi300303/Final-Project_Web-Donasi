@extends('layouts.app')
@section('title','Detail Pengguna')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
<div class="container py-4 theme-blue">
  @include('partials.breadcrumb',['segments'=>['Pengguna','Detail']])

  @php
    $id   = data_get($user,'id');
    $role = is_array(data_get($user,'roles')) ? implode(', ', data_get($user,'roles')) : data_get($user,'role','donatur');
  @endphp

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="mb-3">Informasi Pengguna</h5>
          <div class="row mb-2"><div class="col-sm-4 text-muted">Nama</div><div class="col-sm-8">{{ data_get($user,'name') }}</div></div>
          <div class="row mb-2"><div class="col-sm-4 text-muted">Email</div><div class="col-sm-8">{{ data_get($user,'email') }}</div></div>
          <div class="row mb-2"><div class="col-sm-4 text-muted">Role</div><div class="col-sm-8"><span class="badge bg-info">{{ ucfirst($role) }}</span></div></div>
          <div class="row"><div class="col-sm-4 text-muted">Terdaftar</div><div class="col-sm-8">{{ data_get($user,'created_at') ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') : '—' }}</div></div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body d-flex flex-column gap-2">
          <a href="{{ route('admin.users.edit', $id) }}" class="btn btn-outline-secondary"><i class="fas fa-pen me-1"></i> Edit</a>
          <form action="{{ route('admin.users.destroy', $id) }}" method="POST"> @csrf @method('DELETE')
            <button class="btn btn-outline-danger" onclick="return confirm('Hapus pengguna ini?')"><i class="fas fa-trash me-1"></i> Hapus</button>
          </form>
          <a href="{{ route('admin.users.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
