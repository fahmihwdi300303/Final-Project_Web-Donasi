@extends('layouts.app')
@section('title','Manajemen Pengguna')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
<div class="container py-4 theme-blue">
  @include('partials.breadcrumb',['segments'=>['Pengguna']])
  <x-flash/>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Manajemen Pengguna</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-user-plus me-1"></i> Tambah User</a>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle table-admin">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Terdaftar</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse(($users ?? []) as $i => $u)
              @php
                $id   = data_get($u,'id');
                $role = is_array(data_get($u,'roles')) ? implode(', ', data_get($u,'roles')) : data_get($u,'role','donatur');
              @endphp
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ data_get($u,'name','—') }}</td>
                <td>{{ data_get($u,'email','—') }}</td>
                <td><span class="badge bg-info">{{ ucfirst($role) }}</span></td>
                <td>{{ data_get($u,'created_at') ? \Carbon\Carbon::parse($u->created_at)->format('d/m/Y') : '—' }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.users.show', $id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.users.edit', $id) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></a>
                    <form action="{{ route('admin.users.destroy', $id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus pengguna ini?')">
                        <i class="fas fa-trash"></i>
                    </button>
                    </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted py-5">Belum ada user.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
