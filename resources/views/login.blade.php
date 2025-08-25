<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    </header>
<main class="auth-wrapper" role="main">
    <section class="auth-card" aria-labelledby="login-title">
        <div class="auth-logo">
            <img src="{{ asset('storage\logolksa.png') }}" alt="Logo LKSA">
        </div>
        <h1 id="login-title" class="auth-title">Masuk ke Akun Anda</h1>

        <form action="{{ route('login') }}" method="POST" class="auth-form" novalidate>
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Email" autocomplete="email" required>
                <small class="error" data-error-for="email" aria-live="polite"></small>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input id="password" name="password" type="password" placeholder="Kata Sandi" autocomplete="current-password" required minlength="6">
                <small class="error" data-error-for="password" aria-live="polite"></small>
            </div>

            <div class="form-group"> <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
        </form>

        <div class="extra-links">
            <p>Belum punya akun? <a href="/register">Daftar</a></p>
            <p><a href="/forgot-password">Lupa kata sandi?</a></p>
        </div>
    </section>
</main>
</body>
</html>



