<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login - Presensi Al Asy'ariyyah</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary: #0d9488;
            --primary-dark: #0f766e;
            --primary-light: #14b8a6;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --light: #f0fdfa;
            --white: #ffffff;
            --gray: #94a3b8;
            --border: #e2e8f0;
            --gradient-primary: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            --gradient-branded: linear-gradient(135deg, #0d9488 0%, #059669 50%, #0f766e 100%);
        }

        body {
            min-height: 100vh;
            background: var(--white);
            overflow-x: hidden;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
        }

        .branding-panel {
            flex: 55;
            background: var(--gradient-branded);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 80px;
        }

        .branding-content {
            position: relative;
            z-index: 10;
            max-width: 520px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
        }

        .logo-title {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .logo-subtitle {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.75);
            margin: 4px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .branding-heading {
            font-size: 40px;
            font-weight: 800;
            color: white;
            line-height: 1.15;
            margin: 0 0 16px 0;
            letter-spacing: -1px;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
        }

        .founder-grid {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }

        .founder-card {
            flex-shrink: 0;
            width: 120px;
            overflow: hidden;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: inset 0 0 10px rgba(13, 148, 136, 0.2);
            transition: all 0.3s ease;
        }

        .founder-card:hover {
            transform: translateY(-3px);
        }

        .founder-card img {
            width: 100%;
            height: auto;
            display: block;
        }

        .founder-name {
            text-align: center;
            margin-top: 6px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
        }

        .founder-subtitle {
            text-align: center;
            font-size: 9px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 2px;
        }

        .quote-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 12px 16px;
        }

        .quote-text {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.95);
            font-style: italic;
            line-height: 1.5;
            margin: 0;
        }

        .quote-author {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.55);
            margin: 6px 0 0 0;
            font-weight: 500;
        }

        .blur-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 1;
        }

        .blur-circle-1 { width: 300px; height: 300px; background: rgba(255, 255, 255, 0.15); top: -100px; right: -100px; }
        .blur-circle-2 { width: 200px; height: 200px; background: rgba(255, 255, 255, 0.1); bottom: -50px; left: 50px; }
        .blur-circle-3 { width: 150px; height: 150px; background: rgba(255, 255, 255, 0.08); top: 200px; left: -70px; }
        .blur-circle-4 { width: 250px; height: 250px; background: rgba(255, 255, 255, 0.06); bottom: 100px; right: -80px; }

        .branding-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 0;
        }

        .login-panel {
            flex: 45;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: var(--light);
        }

        .login-wrapper { width: 100%; max-width: 440px; }

        .login-header { text-align: center; margin-bottom: 32px; }

        .login-logo {
            width: 56px; height: 56px;
            background: var(--gradient-primary);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px auto;
            font-size: 24px; color: white;
            box-shadow: 0 4px 20px rgba(13, 148, 136, 0.3);
        }

        .login-title { font-size: 26px; font-weight: 700; color: var(--dark); margin: 0 0 6px 0; letter-spacing: -0.3px; }
        .login-subtitle { font-size: 14px; color: var(--secondary); margin: 0; }

        .login-form {
            background: var(--white);
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04), 0 1px 4px rgba(0,0,0,0.02);
            border: 1px solid var(--border);
        }

        .form-group { margin-bottom: 20px; position: relative; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 13px 16px 13px 44px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.25s ease;
            background: var(--white);
            color: var(--dark);
        }

        .form-input::placeholder { color: #cbd5e1; }
        .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1); }
        .form-input:hover:not(:focus) { border-color: #cbd5e1; }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 15px;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 15px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 4px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 24px 0 28px 0;
        }

        .checkbox-wrapper { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .checkbox-input { width: 18px; height: 18px; border: 1.5px solid var(--border); border-radius: 5px; cursor: pointer; accent-color: var(--primary); }
        .checkbox-label { font-size: 13px; color: var(--secondary); cursor: pointer; font-weight: 400; }
        .forgot-link { font-size: 13px; color: var(--primary); text-decoration: none; font-weight: 500; }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(13, 148, 136, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .submit-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(13, 148, 136, 0.35);
        }

        .divider { display: flex; align-items: center; margin: 24px 0; gap: 12px; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 12px; color: var(--gray); text-transform: uppercase; font-weight: 500; }

        .alert {
            background: #ecfdf5;
            color: #065f46;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #a7f3d0;
        }

@media (max-width: 1024px) {
            .branding-panel { padding: 40px 48px; }
            .branding-heading { font-size: 32px; }
            .founder-card { width: 110px; }
        }

@media (max-width: 768px) {
            .login-container { flex-direction: column; }
            .branding-panel { flex: none; padding: 24px; min-height: 40vh; }
            .branding-heading { font-size: 20px; }
            .founder-grid { gap: 12px; }
            .founder-card { width: 100px; border-radius: 8px; }
            .founder-name { font-size: 10px; margin-top: 4px; }
            .founder-subtitle { font-size: 8px; margin-top: 1px; }
            .quote-box { padding: 10px 14px; margin-top: 10px; }
            .login-panel { flex: none; padding: 20px; }
            .login-form { padding: 24px 20px; border-radius: 16px; }
        }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
        .branding-content { animation: fadeInLeft 0.8s ease 0.2s forwards; opacity: 0; }
        .login-form { animation: fadeInUp 0.6s ease 0.3s forwards; opacity: 0; }
        .login-header { animation: fadeInUp 0.6s ease 0.1s forwards; opacity: 0; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="branding-panel">
            <div class="blur-circle blur-circle-1"></div>
            <div class="blur-circle blur-circle-2"></div>
            <div class="blur-circle blur-circle-3"></div>
            <div class="blur-circle blur-circle-4"></div>

            <div class="branding-content">
                <div class="logo-container">
                    <img src="<?php echo e(asset('images/alasyariyyah logo.png')); ?>" alt="Logo" style="width:64px; height:64px; object-fit:contain; border-radius:16px;" onerror="this.style.display='none';">
                    <div class="logo-text">
                        <h1 class="logo-title">PPTQ Al Asy'ariyyah</h1>
                        <p class="logo-subtitle">Madrasah Diniyah Salafiyah</p>
                    </div>
                </div>

                <h2 class="branding-heading">Sistem Presensi Digital<br>Berbasis Modern</h2>

                <div class="founder-grid">
                    <div class="founder-card">
                        <img src="<?php echo e(asset('images/Simbah KH. Muntaha Alh.jpg')); ?>" alt="KH. Muntaha Alh" onerror="this.parentElement.style.display='none'">
                        <div class="founder-name">KH. Muntaha Alh</div>
                        <div class="founder-subtitle">Masyayikh PPTQ Al-Asy'ariyyah</div>
                    </div>
                    <div class="founder-card">
                        <img src="<?php echo e(asset('images/simbah KH. Mustahal Asy_ari.jpg')); ?>" alt="KH. Mustahal Asy'ari" onerror="this.parentElement.style.display='none'">
                        <div class="founder-name">KH. Mustahal Asy'ari</div>
                        <div class="founder-subtitle">Masyayikh PPTQ Al-Asy'ariyyah</div>
                    </div>
                    <div class="founder-card">
                        <img src="<?php echo e(asset('images/Simbah KH. Ibnu Djauzi.jpg')); ?>" alt="KH. Ibnu Djauzi" onerror="this.parentElement.style.display='none'">
                        <div class="founder-name">KH. Ibnu Djauzi</div>
                        <div class="founder-subtitle">Masyayikh PPTQ Al-Asy'ariyyah</div>
                    </div>
                    <div class="founder-card">
                        <img src="<?php echo e(asset('images/Simbah KH. Faqih Muntaha.jpg')); ?>" alt="KH. Faqih Muntaha" onerror="this.parentElement.style.display='none'">
                        <div class="founder-name">KH. Faqih Muntaha</div>
                        <div class="founder-subtitle">Masyayikh PPTQ Al-Asy'ariyyah</div>
                    </div>
                </div>

                <div class="quote-box">
                    <p class="quote-text">
                        "Awak dinggo berjuang rusak , ora dinggo berjuang yo rusak. Awak dinggo ngibadah rusak, ora dinggo ngibadah yo rusak. Luwih becik dinggo berjuang lan ngibadah."
                    </p>
                    <p class="quote-author">— KH. Muntaha Alh</p>
                </div>
            </div>
        </div>

        <div class="login-panel">
            <div class="login-wrapper">
                <div class="login-header">
                    <div style="position:relative; display:inline-block;">
                        <img src="<?php echo e(asset('images/alasyariyyah logo.png')); ?>" alt="Logo" style="width:64px; height:64px; object-fit:contain; margin:0 auto 16px auto; display:block;" onerror="this.style.display='none';">
                        <div style="position:absolute; inset:0; border-radius:50%; border:2px solid rgba(13,148,136,0.3);"></div>
                    </div>
                    <h2 class="login-title">Selamat Datang Kembali</h2>
                    <p class="login-subtitle">Silakan masuk untuk mengakses sistem</p>
                </div>

                <div class="login-form">
                    <?php if(session('status')): ?>
                    <div class="alert">
                        <i class="fas fa-check-circle"></i>
                        <?php echo e(session('status')); ?>

                    </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                    <div class="alert" style="background:#fef2f2; color:#991b1b; border-color:#fecaca;">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo e($errors->first()); ?>

                    </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="form-group">
                            <label for="login" class="form-label">Username / NIS</label>
                            <div style="position: relative;">
                                <input type="text" id="login" name="login"
                                       class="form-input"
                                       value="<?php echo e(old('login')); ?>"
                                       required autofocus autocomplete="username"
                                       placeholder="Masukkan username atau NIS">
                                <i class="fas fa-user input-icon"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div style="position: relative;">
                                <input type="password" id="password" name="password"
                                       class="form-input"
                                       required autocomplete="current-password"
                                       placeholder="********">
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="toggle-password" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

<div style="margin: 20px 0 16px 0;">
                            <a href="<?php echo e(route('admin.password.request')); ?>" class="forgot-link">Lupa kata sandi?</a>
                        </div>
                        <p style="text-align:center; font-size:11px; color:var(--gray); margin-bottom:24px;">Petugas/Santri: Menghubungi Admin untuk reset password</p>

                        <button type="submit" class="submit-btn" id="submitBtn">
                            <span class="spinner" style="display:none; width:18px; height:18px; border:2px solid rgba(255,255,255,0.3); border-radius:50%; border-top-color:white; animation:spin 0.8s linear infinite;"></span>
                            <span class="btn-text"><i class="fas fa-sign-in-alt"></i> Masuk</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
<?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views/auth/simple-login.blade.php ENDPATH**/ ?>