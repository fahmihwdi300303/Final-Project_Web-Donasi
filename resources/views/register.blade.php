<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <main class="auth-wrapper" role="main">
    <section class="auth-card" aria-labelledby="register-title">
        <div class="auth-logo">
            <img src="{{ asset('storage\logolksa.png') }}" alt="Logo LKSA">
        </div>
        <h1 id="register-title" class="auth-title">Daftar Sekarang!</h1>

        <form method="POST" action="{{ route('register.perform') }}" id="register-form">
            @csrf
            <div class="grid">
                <div class="form-group">
                    <label for="first_name">Nama Depan</label>
                    <input id="first_name" name="first_name" type="text" placeholder="Nama Depan" autocomplete="given-name" required>
                    <small class="error" data-error-for="first_name" aria-live="polite"></small>
                </div>
                <div class="form-group">
                    <label for="last_name">Nama Belakang</label>
                    <input id="last_name" name="last_name" type="text" placeholder="Nama Belakang" autocomplete="family-name" required>
                    <small class="error" data-error-for="last_name" aria-live="polite"></small>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Email" autocomplete="email" required>
                <small class="error" data-error-for="email" aria-live="polite"></small>
            </div>

             <div class="form-group">
          <label for="phone">Nomor WhatsApp / HP</label>
          <input id="phone" name="phone" type="tel" placeholder="+62xxxxxxxxxx" required>
          <small class="error" data-error-for="phone"></small>
        </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input id="password" name="password" type="password" placeholder="Kata Sandi" autocomplete="new-password" required minlength="6">
                <small class="error" data-error-for="password" aria-live="polite"></small>
            </div>

            <div class="form-actions" form>
                <button type="submit" class="btn btn-primary">Daftar</button>
            </div>
        </form>
        <div class="extra-links">
            <p>Sudah punya akun? <a href="/login">Masuk</a></p>
        </div>
    </section>
    <script>
        document.getElementById('register-form').addEventListener('submit', function(){
        const fn = (document.getElementById('first_name')?.value || '').trim();
        const ln = (document.getElementById('last_name')?.value  || '').trim();
        document.getElementById('full_name').value = (fn + ' ' + ln).trim() || fn || ln;
    });
</script>
</main>

