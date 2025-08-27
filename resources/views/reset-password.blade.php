@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-12 bg-white rounded-xl shadow p-6">
  <h1 class="text-2xl font-bold mb-4">Atur Ulang Kata Sandi</h1>

  @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded mb-3">
      <ul class="list-disc ml-5">
        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  @if (session('status'))
    <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded mb-3">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div>
      <label class="block text-sm mb-1">Email</label>
      <input type="email" name="email" class="w-full border rounded px-3 py-2" required value="{{ old('email') }}">
    </div>
    <div>
      <label class="block text-sm mb-1">Password Baru</label>
      <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
  </form>
</div>
@endsection
