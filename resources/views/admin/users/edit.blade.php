@extends('layouts.app')
@section('title','Edit Pengguna')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
<div class="container py-4 theme-blue">
  @include('partials.breadcrumb',['segments'=>['Pengguna','Edit']])
  <x-flash/>

  <div class="card">
    <div class="card-body">
      @php $id = data_get($user,'id'); @endphp
      <form action="{{ route('admin.users.update', $id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ data_get($user,'name') }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ data_get($user,'email') }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Password (kosongkan bila tidak diubah)</label>
            <input type="password" name="password" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Role</label>
            @php $r = strtolower(data_get($user,'role','donatur')); @endphp
            <select name="role" class="form-select">
              <option value="donatur" {{ $r==='donatur'?'selected':'' }}>Donatur</option>
              <option value="admin"   {{ $r==='admin'?'selected':'' }}>Admin</option>
            </select>
          </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Kembali</a>
          <button class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
