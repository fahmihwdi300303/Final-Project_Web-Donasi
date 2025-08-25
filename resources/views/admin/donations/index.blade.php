@extends('layouts.app')
@section('title','Manajemen Donasi')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Manajemen Donasi</h1>
    <a href="{{ route('admin.donations.create') }}" class="btn btn-primary">
      <i class="fas fa-plus me-1"></i> Tambah Donasi
    </a>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
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
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $d->created_at?->format('d/m/Y H:i') }}</td>
                <td>{{ $d->user->name ?? '—' }}</td>
                <td>Rp {{ number_format($d->jumlah ?? 0,0,',','.') }}</td>
                <td>{{ strtoupper($d->metode_pembayaran ?? '-') }}</td>
                <td>
                  <span class="badge bg-{{ $d->status==='verified'?'success':($d->status==='pending'?'warning text-dark':'danger') }}">
                    {{ ucfirst($d->status ?? 'pending') }}
                  </span>
                </td>
                <td class="text-end">
                  <a href="{{ route('admin.donations.show',$d->donation_id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.donations.edit',$d->donation_id) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-pen"></i>
                  </a>
                  <form action="{{ route('admin.donations.destroy',$d->donation_id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus donasi ini?')">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-5">
                  Belum ada data donasi.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<a href="{{ Route::has('admin.donations.show') ? route('admin.donations.show',$d->donation_id) : url('/admin/donations/'.$d->donation_id) }}"
   class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>

<a href="{{ Route::has('admin.donations.edit') ? route('admin.donations.edit',$d->donation_id) : url('/admin/donations/'.$d->donation_id.'/edit') }}"
   class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></a>

<form action="{{ Route::has('admin.donations.destroy') ? route('admin.donations.destroy',$d->donation_id) : url('/admin/donations/'.$d->donation_id) }}"
      method="POST" class="d-inline">
  @csrf @method('DELETE')
  <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus donasi ini?')">
    <i class="fas fa-trash"></i>
  </button>
</form>
@endsection
