@extends('layouts.app')
@section('title','Manajemen Donasi')
@php use Illuminate\Support\Facades\Route; @endphp

@section('content')
<div class="container py-4 theme-blue">
  @include('partials.breadcrumb',['segments'=>['Donasi']])
  <x-flash/>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0">Manajemen Donasi</h1>

    <div class="btn-group">
    <a class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" href="#">+ Tambah Donasi</a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('admin.donations.create-money') }}">Donasi Uang</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.donations.create-goods') }}">Donasi Barang</a></li>
    </ul>
    </div>
</div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle table-admin">
          <thead>
            <tr>
              <th>#</th>
              <th>Tanggal</th>
              <th>Donatur</th>
              <th>Jumlah</th>
              <th>Metode</th>
              <th>Status</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse(($donations ?? []) as $i => $d)
              @php
                $id     = data_get($d,'donation_id', data_get($d,'id'));
                $nama   = data_get($d,'user.name','—');
                $jumlah = data_get($d,'jumlah', data_get($d,'amount',0));
                $metode = strtoupper(data_get($d,'metode_pembayaran', data_get($d,'method','-')));
                $status = strtolower(data_get($d,'status','pending'));
              @endphp
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ data_get($d,'created_at') ? \Carbon\Carbon::parse($d->created_at)->format('d/m/Y H:i') : '—' }}</td>
                <td>{{ $nama }}</td>
                <td>Rp {{ number_format($jumlah,0,',','.') }}</td>
                <td>{{ $metode }}</td>
                <td>
                  <span class="badge bg-{{ $status==='verified'?'success':($status==='pending'?'warning text-dark':'danger') }}">
                    {{ ucfirst($status) }}
                  </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('admin.donations.show', $id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.donations.edit', $id) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></a>
                    <form action="{{ route('admin.donations.destroy', $id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus donasi ini?')">
                        <i class="fas fa-trash"></i>
                    </button>
                    </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-center text-muted py-5">Belum ada data donasi.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
