@extends('layouts.app')

@section('title','Manajemen Donasi')

@section('content')
<div class="container py-4">
    @includeFirst(['partials.navbar.breadcrumb','partials.breadcrumb'], ['segments'=>['Donasi']])
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 m-0">Manajemen Donasi</h1>
        {{-- tombol tambah (admin create manual) --}}
        <a href="{{ route('admin.donations.create') }}" class="btn btn-primary">+ Tambah Donasi</a>
    </div>

    {{-- Filter sederhana --}}
    <form class="row g-2 mb-3" method="get">
        <div class="col-auto">
            <input type="text" name="s" value="{{ request('s') }}" class="form-control" placeholder="Cari donatur (nama/email)">
        </div>
        <div class="col-auto">
            <select name="status" class="form-select">
                <option value="">Semua status</option>
                @foreach (['pending'=>'Pending','verified'=>'Verified','rejected'=>'Rejected'] as $k=>$v)
                    <option value="{{ $k }}" @selected(request('status')===$k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <select name="metode" class="form-select">
                <option value="">Semua metode</option>
                @foreach (['qris'=>'QRIS','transfer'=>'Transfer','cash'=>'Cash','barang'=>'Barang'] as $k=>$v)
                    <option value="{{ $k }}" @selected(request('metode')===$k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-primary">Filter</button>
        </div>
    </form>

    <div class="card">
        <div class="card-body table-responsive overflow-visible" >
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
                    @php $no = ($donations->currentPage()-1) * $donations->perPage(); @endphp
                    @forelse ($donations as $d)
                        @php
                            $badge = ['pending'=>'warning','verified'=>'success','rejected'=>'danger'][$d->status] ?? 'secondary';
                        @endphp
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ optional($d->created_at)->format('d M Y') }}</td>
                            <td>
                                {{ optional($d->user)->name ?? '—' }}
                                <div class="small text-muted">{{ optional($d->user)->email }}</div>
                            </td>
                            <td>Rp {{ number_format((int) $d->jumlah, 0, ',', '.') }}</td>
                            <td class="text-uppercase">{{ $d->metode_pembayaran }}</td>
                            <td>
                                <span class="badge bg-{{ $badge }}">{{ ucfirst($d->status) }}</span>
                            </td>

                            {{-- Aksi di kolom terakhir --}}
                            <td class="text-end">
                            <div class="dropdown position-static">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        data-bs-display="static"   {{-- penting: cegah ter-clip oleh overflow --}}
                                        aria-expanded="false">
                                Aksi
                                </button>

                                <div class="dropdown-menu dropdown-menu-end shadow">
                                {{-- Verified --}}
                                <form action="{{ route('admin.donations.status', ['donation' => $d->getKey()]) }}" method="POST" class="px-2">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="verified">
                                    <button type="submit" class="dropdown-item">Tandai Verified</button>
                                </form>

                                {{-- Pending --}}
                                <form action="{{ route('admin.donations.status', ['donation' => $d->getKey()]) }}" method="POST" class="px-2">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="pending">
                                    <button type="submit" class="dropdown-item">Tandai Pending</button>
                                </form>

                                {{-- Rejected --}}
                                <form action="{{ route('admin.donations.status', ['donation' => $d->getKey()]) }}" method="POST" class="px-2">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="dropdown-item text-danger">Tandai Rejected</button>
                                </form>
                                </div>
                            </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">Belum ada data donasi.</td>
                        </tr>
                    @endforelse
                    </tbody>

            </table>
            <div class="mt-3">
                {{ $donations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
