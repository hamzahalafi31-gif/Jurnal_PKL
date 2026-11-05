
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Jurnal PKL</title>

    <!-- Bootstrap CSS Lokal -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        :root {
            --primary: #173B75;
            --secondary: #2878D0;
            --light-blue: #EAF2FC;
            --text-dark: #243B5A;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;

            font-family: Arial, sans-serif;

            background: linear-gradient(
                135deg,
                #EAF2FC,
                #C9DDF7,
                #2878D0
            );

            position: relative;
            overflow-x: hidden;
        }

        /* Dekorasi Background */

        body::before,
        body::after {
            content: "";
            position: fixed;
            border-radius: 50%;
            background: rgba(255,255,255,0.18);
            z-index: -1;
            pointer-events: none;
            animation: floating 8s ease-in-out infinite;
        }

        body::before {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
        }

        body::after {
            width: 250px;
            height: 250px;
            bottom: -80px;
            right: -70px;
            animation-delay: 2s;
        }

        @keyframes floating {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-25px);
            }
        }

        /* Login Card */

        .login-card {
            width: 100%;
            max-width: 430px;

            border: none;
            border-radius: 22px;
            overflow: hidden;

            background: #FFFFFF;

            box-shadow: 0 20px 50px rgba(23,59,117,0.20);

            animation: fadeUp 0.8s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(35px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */

        .login-header {
            background: linear-gradient(
                135deg,
                #173B75,
                #2878D0
            );

            color: white;
            padding: 35px 25px;
            text-align: center;
        }

        .login-icon {
            width: 85px;
            height: 85px;

            margin: 0 auto 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 22px;

            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.25);

            font-size: 40px;

            transition: 0.3s ease;
        }

        .login-icon:hover {
            transform: rotate(-8deg) scale(1.08);
        }

        .login-header h3 {
            font-weight: bold;
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 14px;
            margin: 0;
            color: #EAF2FC;
        }

        /* Body */

        .login-body {
            padding: 35px 30px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #DCE6F2;
            border-radius: 10px;
            padding: 13px 15px;
            background: #F7F9FD;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: #FFFFFF;
            border-color: var(--secondary);

            box-shadow: 0 0 0 4px rgba(40,120,208,0.12);
        }

        /* Login Button */

        .btn-login {
            background: linear-gradient(
                135deg,
                #173B75,
                #2878D0
            );

            color: white;
            border: none;
            border-radius: 10px;

            padding: 14px;
            font-weight: bold;

            transition: all 0.3s ease;
        }

        .btn-login:hover {
            color: white;
            transform: translateY(-3px);

            box-shadow: 0 10px 22px rgba(40,120,208,0.3);
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        /* Footer */

        .login-footer {
            background: #F5F8FD;
            border-top: 1px solid #E5EDF8;

            padding: 23px 20px;
            text-align: center;
        }

        .login-footer a {
            color: var(--secondary);
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .login-footer a:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        /* Alert */

        .alert {
            border: none;
            border-radius: 10px;
            font-size: 14px;
        }

        /* Responsive */

        @media (max-width: 480px) {
            .login-body {
                padding: 25px 20px;
            }

            .login-header {
                padding: 28px 20px;
            }

            .login-card {
                border-radius: 16px;
            }
        }

        /* Accessibility */

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="login-card card">

        <!-- Header -->
        <div class="login-header">

            <div class="login-icon">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>

            <h3>Jurnal PKL</h3>

            <p>
                Sistem Informasi Praktik Kerja Lapangan
            </p>

        </div>

        <!-- Body -->
        <div class="login-body">

            <!-- Pesan Error -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">

                    <i class="bi bi-exclamation-triangle-fill me-2"></i>

                    <?= esc(session()->getFlashdata('error')) ?>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('salahpw')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">

                    <i class="bi bi-exclamation-triangle-fill me-2"></i>

                    <?= esc(session()->getFlashdata('salahpw')) ?>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    <?= esc(session()->getFlashdata('success')) ?>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>
            <?php endif; ?>

            <!-- Form Login -->
            <form action="<?= base_url('/proses-login') ?>" method="post" novalidate>

                <div class="mb-4">

                    <label for="username" class="form-label">
                        <i class="bi bi-person me-2"></i>
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        id="username"
                        placeholder="Masukkan username"
                        required
                        autocomplete="username"
                    >

                </div>

                <div class="mb-4">

                    <label for="password" class="form-label">
                        <i class="bi bi-lock me-2"></i>
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        id="password"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password"
                    >

                </div>

                <button type="submit" class="btn btn-login w-100">

                    <i class="bi bi-box-arrow-in-right me-2"></i>

                    Login Sekarang

                </button>

            </form>

        </div>

        <!-- Footer -->
        <div class="login-footer">

            <p class="mb-0 text-muted small">

                Belum punya akun?

                <a href="<?= base_url('register') ?>">

                    <i class="bi bi-person-plus me-1"></i>

                    Daftar Sekarang

                </a>

            </p>

        </div>

    </div>

    <!-- Bootstrap JS Lokal -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

</body>

</html>
