
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Jurnal PKL</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 30px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #eaf3ff, #f8fbff, #dceaff);
            overflow-x: hidden;
            position: relative;
        }

        .background-circle {
            position: fixed;
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.08);
            z-index: -1;
        }

        .circle-one {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
        }

        .circle-two {
            width: 250px;
            height: 250px;
            bottom: -80px;
            right: -70px;
        }

        .register-card {
            width: 100%;
            max-width: 480px;
            border: none;
            border-radius: 22px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 15px 50px rgba(30, 64, 175, 0.13);
            animation: fadeUp 0.7s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            padding: 35px 25px 30px;
            text-align: center;
            color: white;
            background: linear-gradient(135deg, #2563eb, #1e40af);
        }

        .register-icon {
            width: 75px;
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 17px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.17);
            font-size: 36px;
        }

        .register-header h3 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .register-header p {
            margin: 9px 0 0;
            color: #dbeafe;
            font-size: 14px;
        }

        .register-body {
            padding: 30px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-group-text {
            background: #f1f6ff;
            border-color: #dbeafe;
            color: #2563eb;
        }

        .form-control {
            border-color: #dbeafe;
            padding: 12px 14px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12);
        }

        .input-group .form-control {
            border-left: none;
        }

        .btn-register {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            color: white;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }

        .register-footer {
            padding: 20px;
            text-align: center;
            background: #f8fbff;
            border-top: 1px solid #edf2fa;
        }

        .register-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            font-size: 14px;
        }

        .password-strength {
            height: 5px;
            margin-top: 10px;
            border-radius: 10px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .password-strength .bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .password-strength .bar.weak {
            width: 25%;
            background: #ef4444;
        }

        .password-strength .bar.fair {
            width: 50%;
            background: #f59e0b;
        }

        .password-strength .bar.good {
            width: 75%;
            background: #0ea5e9;
        }

        .password-strength .bar.strong {
            width: 100%;
            background: #16a34a;
        }

        #passwordText {
            display: block;
            margin-top: 7px;
        }

        @media (max-width: 480px) {
            .register-body {
                padding: 24px 20px;
            }

            .register-header {
                padding: 30px 20px;
            }

            .register-card {
                border-radius: 17px;
            }
        }
    </style>
</head>

<body>

    <div class="background-circle circle-one"></div>
    <div class="background-circle circle-two"></div>

    <div class="register-card card">

        <div class="register-header">
            <div class="register-icon">
                <i class="bi bi-person-plus-fill"></i>
            </div>

            <h3>Buat Akun Baru</h3>
            <p>Sistem Informasi Jurnal Praktik Kerja Lapangan</p>
        </div>

        <div class="register-body">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/register/store') ?>" method="post">

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input
                            type="text"
                            name="nama"
                            id="nama"
                            class="form-control"
                            placeholder="Masukkan nama lengkap"
                            required
                            autocomplete="name"
                            value="<?= old('nama') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            placeholder="Masukkan email"
                            required
                            autocomplete="email"
                            value="<?= old('email') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-at"></i>
                        </span>
                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="form-control"
                            placeholder="Buat username"
                            required
                            autocomplete="username"
                            value="<?= old('username') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Minimal 6 karakter"
                            required
                            autocomplete="new-password"
                            minlength="6">
                    </div>

                    <div class="password-strength" id="passwordStrength">
                        <div class="bar"></div>
                    </div>

                    <small class="text-muted" id="passwordText"></small>
                </div>

                <div class="mb-4">
                    <label for="password_confirm" class="form-label">
                        Konfirmasi Password
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-shield-lock"></i>
                        </span>
                        <input
                            type="password"
                            name="password_confirm"
                            id="password_confirm"
                            class="form-control"
                            placeholder="Ulangi password"
                            required
                            autocomplete="new-password">
                    </div>
                </div>

                <button type="submit" class="btn btn-register">
                    <i class="bi bi-person-check-fill me-2"></i>
                    Daftar Sekarang
                </button>

            </form>
        </div>

        <div class="register-footer">
            <p class="mb-0 text-muted small">
                Sudah memiliki akun?
                <a href="<?= base_url('login') ?>">
                    Login di sini
                    <i class="bi bi-arrow-right"></i>
                </a>
            </p>
        </div>

    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const passwordInput = document.getElementById('password');
            const strengthBar = document.querySelector('#passwordStrength .bar');
            const strengthText = document.getElementById('passwordText');
            const confirmInput = document.getElementById('password_confirm');
            const registerForm = document.querySelector('form');

            // Indikator kekuatan password
            passwordInput.addEventListener('input', function() {

                const password = this.value;
                let strength = 0;
                let text = '';

                if (password.length >= 6) strength += 25;
                if (password.length >= 8) strength += 10;
                if (password.length >= 12) strength += 10;

                if (/[a-z]/.test(password)) strength += 10;
                if (/[A-Z]/.test(password)) strength += 10;
                if (/[0-9]/.test(password)) strength += 10;
                if (/[^a-zA-Z0-9]/.test(password)) strength += 15;

                strength = Math.min(strength, 100);

                strengthBar.style.width = strength + '%';
                strengthBar.className = 'bar';

                if (strength < 30) {
                    strengthBar.classList.add('weak');
                    text = 'Lemah';
                } else if (strength < 50) {
                    strengthBar.classList.add('fair');
                    text = 'Cukup';
                } else if (strength < 75) {
                    strengthBar.classList.add('good');
                    text = 'Baik';
                } else {
                    strengthBar.classList.add('strong');
                    text = 'Kuat';
                }

                strengthText.textContent = password.length > 0
                    ? 'Kekuatan password: ' + text
                    : '';

            });

            // Validasi form sebelum dikirim
            registerForm.addEventListener('submit', function(e) {

                const password = passwordInput.value;
                const confirmPassword = confirmInput.value;

                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Password dan konfirmasi password tidak cocok!');
                    confirmInput.focus();
                    return false;
                }

                if (password.length < 6) {
                    e.preventDefault();
                    alert('Password minimal 6 karakter!');
                    passwordInput.focus();
                    return false;
                }

            });

        });
    </script>

</body>
</html>
