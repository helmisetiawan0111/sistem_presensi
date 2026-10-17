<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }

            body {
                font-family: 'Poppins', sans-serif;
                margin: 0;
                min-height: 100vh;
                background: linear-gradient(135deg, #0d9488 0%, #0f766e 50%, #059669 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .container {
                width: 100%;
                max-width: 440px;
            }

            .card {
                background: #ffffff;
                padding: 40px 36px;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(0,0,0,0.04);
                border: 1px solid #e2e8f0;
            }

            .card-header {
                text-align: center;
                margin-bottom: 28px;
            }

            .card-header .login-icon {
                width: 56px;
                height: 56px;
                background: linear-gradient(135deg, #0d9488, #0f766e);
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 16px auto;
                font-size: 24px;
                color: white;
                box-shadow: 0 4px 20px rgba(13, 148, 136, 0.3);
            }

            .card-header h2 {
                font-size: 22px;
                font-weight: 700;
                color: #0f172a;
                margin: 0 0 6px 0;
            }

            .card-header p {
                font-size: 13px;
                color: #64748b;
                margin: 0;
            }

            .title {
                text-align: center;
                margin-bottom: 8px;
                font-size: 22px;
                font-weight: 700;
                color: #0f172a;
            }

            .form-group {
                margin-bottom: 18px;
                position: relative;
            }

            .form-group label {
                display: block;
                font-size: 13px;
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 6px;
            }

            .form-group input {
                width: 100%;
                padding: 12px 16px;
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
                font-size: 14px;
                font-family: 'Poppins', sans-serif;
                transition: all 0.25s ease;
                background: #ffffff;
                color: #0f172a;
                box-sizing: border-box;
            }

            .form-group input::placeholder {
                color: #cbd5e1;
            }

            .form-group input:focus {
                outline: none;
                border-color: #0d9488;
                box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1);
            }

            .form-group input:hover:not(:focus) {
                border-color: #cbd5e1;
            }

            .btn-primary {
                width: 100%;
                padding: 13px;
                background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
                color: white;
                border: none;
                border-radius: 12px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 16px rgba(13, 148, 136, 0.25);
                letter-spacing: 0.3px;
                font-family: 'Poppins', sans-serif;
                margin-top: 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 24px rgba(13, 148, 136, 0.35);
                background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
            }

            .btn-primary:active {
                transform: translateY(0);
                box-shadow: 0 2px 12px rgba(13, 148, 136, 0.3);
            }

            .divider {
                display: flex;
                align-items: center;
                margin: 20px 0;
                gap: 12px;
            }

            .divider::before,
            .divider::after {
                content: '';
                flex: 1;
                height: 1px;
                background: #e2e8f0;
            }

            .divider span {
                font-size: 12px;
                color: #94a3b8;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-weight: 500;
            }

            .alert {
                padding: 12px 16px;
                border-radius: 12px;
                margin-bottom: 16px;
                font-size: 13px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .alert-success {
                background: #ecfdf5;
                color: #065f46;
                border: 1px solid #a7f3d0;
            }

            .alert-success i {
                color: #0d9488;
            }

            .alert-danger {
                background: #fef2f2;
                color: #991b1b;
                border: 1px solid #fecaca;
            }

            .alert-danger i {
                color: #ef4444;
            }

            .remember-me {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 20px;
            }

            .remember-me input[type="checkbox"] {
                width: 18px;
                height: 18px;
                border: 1.5px solid #e2e8f0;
                border-radius: 5px;
                cursor: pointer;
                accent-color: #0d9488;
            }

            .remember-me input[type="checkbox"]:hover {
                border-color: #0d9488;
            }

            .remember-me label {
                font-size: 13px;
                color: #64748b;
                cursor: pointer;
            }

            .forgot-link {
                font-size: 13px;
                color: #0d9488;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.2s;
            }

            .forgot-link:hover {
                color: #0f766e;
                text-decoration: underline;
                text-underline-offset: 3px;
            }

            .input-error {
                font-size: 12px;
                color: #ef4444;
                margin-top: 4px;
            }

            .toggle-password {
                position: absolute;
                right: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                font-size: 15px;
                cursor: pointer;
                background: none;
                border: none;
                padding: 4px;
                transition: color 0.25s ease;
            }

            .toggle-password:hover {
                color: #0d9488;
            }

            .input-wrapper {
                position: relative;
            }

            .input-icon {
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                font-size: 15px;
                transition: color 0.25s ease;
                pointer-events: none;
            }

            .form-group input:focus ~ .input-icon {
                color: #0d9488;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="login-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h2>Selamat Datang</h2>
                    <p>Silakan masuk untuk mengakses sistem</p>
                </div>

                <?php echo e($slot); ?>

            </div>
        </div>
    </body>
</html><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\layouts\guest.blade.php ENDPATH**/ ?>