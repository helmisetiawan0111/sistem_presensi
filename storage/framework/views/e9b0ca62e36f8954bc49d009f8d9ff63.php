<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password Admin - Presensi Al Asy'ariyyah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        :root { --primary: #0d9488; --dark: #0f172a; --light: #f0fdfa; --gray: #94a3b8; --border: #e2e8f0; }
        body { min-height: 100vh; background: var(--light); display: flex; align-items: center; justify-content: center; padding: 20px; }
        .reset-card { background: white; border-radius: 16px; padding: 32px; max-width: 400px; width: 100%; box-shadow: 0 4px 24px rgba(0,0,0,0.04); border: 1px solid var(--border); }
        .reset-title { font-size: 22px; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
        .reset-desc { font-size: 14px; color: var(--gray); margin-bottom: 24px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px; }
        .form-input { width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; }
        .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1); }
        .submit-btn { width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .submit-btn:hover { background: #0f766e; }
        .back-link { display: block; text-align: center; margin-top: 20px; font-size: 13px; color: var(--primary); text-decoration: none; }
        .alert { background: #ecfdf5; color: #065f46; padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
</head>
<body>
    <div class="reset-card">
        <h2 class="reset-title">Lupa Password Admin</h2>
        <p class="reset-desc">Masukkan username dan email terdaftar untuk reset password.</p>

        <?php if(session('status')): ?>
        <div class="alert"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
        <div class="alert alert-error"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.password.email')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="login" class="form-label">Username Admin</label>
                <input type="text" id="login" name="login" class="form-input" value="<?php echo e(old('login')); ?>" required placeholder="Masukkan username">
            </div>
            <div class="form-group">
                <label for="email_verification" class="form-label">Email Terdaftar</label>
                <input type="email" id="email_verification" name="email_verification" class="form-input" value="<?php echo e(old('email_verification')); ?>" required placeholder="Masukkan email yang terdaftar">
            </div>
            <button type="submit" class="submit-btn">Reset Password</button>
        </form>
        <a href="<?php echo e(route('login')); ?>" class="back-link">Kembali ke Login</a>
    </div>
</body>
</html><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\auth\admin-forgot-password.blade.php ENDPATH**/ ?>