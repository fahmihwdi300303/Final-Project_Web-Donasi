{{-- Di akhir .header-buttons --}}
@auth
  <div class="header-buttons">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Dashboard</a>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-outline">Logout</button>
    </form>
  </div>
@else
  <div class="header-buttons">
    <button class="btn btn-outline" onclick="goToLogin()">Masuk</button>
    <button class="btn btn-primary" onclick="goToRegister()">Daftar</button>
  </div>
@endauth
