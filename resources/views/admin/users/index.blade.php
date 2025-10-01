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
              {{-- <th class="text-end">Aksi</th> --}}
            </tr>
          </thead>
            <tbody>
            @forelse ($users as $u)
                <tr>
                    <td>{{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        {{-- dukung spatie/permission ATAU kolom role biasa --}}
                        {{ method_exists($u,'getRoleNames') ? ($u->getRoleNames()->first() ?? '-') : ($u->role ?? '-') }}
                    </td>
                    <td>{{ optional($u->created_at)->format('d M Y') }}</td>
                    <td><!-- Aksi --></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada user.</td>
                </tr>
            @endforelse
            </tbody>

            {{-- pagination (opsional) --}}
            @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            @endif

        </table>
      </div>
    </div>
  </div>
</div>
@endsection
