<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Presensi Al Asy'ariyyah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        :root { --primary: #0d9488; --dark: #0f172a; --gray: #94a3b8; --border: #e2e8f0; --light: #f0fdfa; --white: #ffffff; --warning: #f59e0b; }
        body { min-height: 100vh; background: white; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .login-wrapper { width: 100%; max-width: 500px; }
        .login-header { text-align: center; margin-bottom: 32px; }
        .login-logo { width: 64px; height: 64px; background: var(--primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; font-size: 28px; color: white; box-shadow: 0 4px 20px rgba(13, 148, 136, 0.3); }
        .login-form { background: var(--white); border-radius: 24px; padding: 44px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0,0,0,0.04); border: 1px solid var(--border); }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px; }
        .input-wrapper { position: relative; display: flex; align-items: center; }
        .input-wrapper .form-input { width: 100%; }
        .input-wrapper .input-icon { position: absolute; left: 14px; color: var(--gray); font-size: 15px; }
        .input-wrapper .toggle-password { position: absolute; right: 14px; color: var(--gray); font-size: 15px; cursor: pointer; background: none; border: none; padding: 4px; }
        .form-input { padding: 13px 42px 13px 44px; border: 1.5px solid var(--border); border-radius: 12px; font-size: 14px; transition: all 0.25s ease; background: var(--white); color: var(--dark); width: 100%; }
        .form-input::placeholder { color: #cbd5e1; }
        .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1); }
        .form-input:hover:not(:focus) { border-color: #cbd5e1; }
        .submit-btn { width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: 12px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(13, 148, 136, 0.25); display: flex; align-items: center; justify-content: center; gap: 8px; }
        .submit-btn:hover { background: #0f766e; transform: translateY(-2px); }
        .back-link { display: block; text-align: center; margin-top: 20px; font-size: 13px; color: var(--primary); text-decoration: none; }
        .alert { background: #ecfdf5; color: #065f46; padding: 14px 18px; border-radius: 12px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; border: 1px solid #a7f3d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-header">
            <div class="login-logo" style="background: var(--warning);">
                <i class="fas fa-key"></i>
            </div>
            <h2 class="login-title">Reset Kata Sandi</h2>
            <p class="login-subtitle">Masukkan kata sandi baru untuk akun Anda.</p>
        </div>

        <div class="login-form">
                @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $request->email) }}" readonly style="background: #f8fafc;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi Baru</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" class="form-input" required autocomplete="new-password" placeholder="Password baru (min 8 karakter)">
                            <button type="button" class="toggle-password" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="fas fa-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required autocomplete="new-password" placeholder="Ulangi password baru">
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                <i class="fas fa-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-save"></i>
                        Reset Kata Sandi
                    </button>
                </form>
                <a href="{{ route('login') }}" class="back-link">Kembali ke Login</a>
            </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
