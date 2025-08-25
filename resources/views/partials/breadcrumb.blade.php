@include('partials.breadcrumb', ['segments' => ['Donasi']])
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
    @foreach(($segments ?? []) as $seg)
      <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}" aria-current="{{ $loop->last ? 'page' : '' }}">
        {{ $seg }}
      </li>
    @endforeach
  </ol>
</nav>
