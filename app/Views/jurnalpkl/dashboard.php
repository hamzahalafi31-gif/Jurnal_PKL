
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Dashboard Jurnal PKL
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .dashboard-wrapper {
        padding: 25px 0;
    }

    .welcome-card {
        position: relative;
        overflow: hidden;
        padding: 30px;
        border-radius: 18px;
        color: white;
        background: linear-gradient(120deg, #2563eb, #1e40af);
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15);
        margin-bottom: 30px;
    }

    .welcome-card::after {
        content: "";
        position: absolute;
        width: 210px;
        height: 210px;
        right: -55px;
        top: -95px;
        border-radius: 50%;
        background: rgba(255,255,255,0.10);
    }

    .welcome-card::before {
        content: "";
        position: absolute;
        width: 130px;
        height: 130px;
        right: 100px;
        bottom: -95px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
    }

    .welcome-content {
        position: relative;
        z-index: 1;
    }

    .welcome-card h3 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .welcome-card p {
        margin-bottom: 0;
        color: #dbeafe;
    }

    .dashboard-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .section-heading {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
    }

    .menu-card {
        height: 100%;
        padding: 24px;
        background: #fff;
        border: 1px solid #e8eef8;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
        transition: all 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(37, 99, 235, 0.10);
        border-color: #bfdbfe;
    }

    .menu-icon {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 25px;
        margin-bottom: 20px;
    }

    .icon-blue {
        color: #2563eb;
        background: #eff6ff;
    }

    .icon-green {
        color: #059669;
        background: #ecfdf5;
    }

    .icon-orange {
        color: #ea580c;
        background: #fff7ed;
    }

    .icon-purple {
        color: #7c3aed;
        background: #f5f3ff;
    }

    .menu-card h5 {
        color: #1e293b;
        font-weight: 700;
        font-size: 17px;
        margin-bottom: 9px;
    }

    .menu-card p {
        color: #64748b;
        font-size: 13px;
        min-height: 40px;
        margin-bottom: 18px;
    }

    .menu-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .menu-button:hover {
        color: white;
        background: #2563eb;
    }

    .information-card {
        padding: 25px;
        margin-top: 30px;
        background: #fff;
        border: 1px solid #e8eef8;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
    }

    .information-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 12px;
        font-size: 21px;
    }

    .information-card h5 {
        font-weight: 700;
        color: #1e293b;
    }

    .information-card p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 0;
    }

    @media (max-width: 576px) {
        .welcome-card {
            padding: 23px;
        }

        .dashboard-wrapper {
            padding: 15px 0;
        }

        .menu-card {
            padding: 20px;
        }
    }
</style>

<div class="container-fluid dashboard-wrapper">

    <!-- Header Sambutan -->
    <div class="welcome-card">
        <div class="welcome-content">
            <div class="dashboard-label text-white opacity-75">
                Sistem Informasi Praktik Kerja Lapangan
            </div>

            <h3>
                Selamat Datang, <?= esc(session()->get('nama')) ?>!
            </h3>

            <p>
                Semoga kegiatan PKL hari ini berjalan lancar.
                Jangan lupa mencatat setiap aktivitas dan perkembanganmu.
            </p>
        </div>
    </div>

    <!-- Menu Utama -->
    <div class="mb-4">
        <div class="dashboard-label">Navigasi Aplikasi</div>
        <h4 class="section-heading">Menu Utama</h4>
    </div>

    <div class="row g-4">

        <!-- Presensi -->
        <div class="col-xl-3 col-md-6">
            <div class="menu-card">
                <div class="menu-icon icon-blue">
                    <i class="bi bi-calendar-check"></i>
                </div>

                <h5>Presensi PKL</h5>

                <p>
                    Catat dan pantau kehadiran selama melaksanakan
                    kegiatan praktik kerja lapangan.
                </p>

                <a href="<?= base_url('presensi') ?>" class="menu-button">
                    Buka Presensi
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Task Management -->
        <div class="col-xl-3 col-md-6">
            <div class="menu-card">
                <div class="menu-icon icon-green">
                    <i class="bi bi-list-task"></i>
                </div>

                <h5>Task Management</h5>

                <p>
                    Lihat dan kelola daftar tugas yang diberikan
                    selama kegiatan PKL.
                </p>

                <a href="<?= base_url('task') ?>" class="menu-button">
                    Buka Tugas
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Jurnal -->
        <div class="col-xl-3 col-md-6">
            <div class="menu-card">
                <div class="menu-icon icon-orange">
                    <i class="bi bi-journal-text"></i>
                </div>

                <h5>Jurnal Aktivitas</h5>

                <p>
                    Dokumentasikan kegiatan dan pekerjaan
                    yang dilakukan setiap hari.
                </p>

                <a href="<?= base_url('jurnal') ?>" class="menu-button">
                    Buka Jurnal
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Chatroom -->
        <div class="col-xl-3 col-md-6">
            <div class="menu-card">
                <div class="menu-icon icon-purple">
                    <i class="bi bi-chat-dots"></i>
                </div>

                <h5>Chatroom</h5>

                <p>
                    Berkomunikasi dan berdiskusi dengan
                    anggota kelompok PKL.
                </p>

                <a href="<?= base_url('chat') ?>" class="menu-button">
                    Buka Chat
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Informasi -->
    <div class="information-card">
        <div class="d-flex align-items-start gap-3">

            <div class="information-icon flex-shrink-0">
                <i class="bi bi-info-circle"></i>
            </div>

            <div>
                <h5>Informasi Aplikasi</h5>

                <p>
                    Gunakan aplikasi Jurnal PKL untuk mencatat
                    kehadiran, mengelola tugas, mendokumentasikan
                    kegiatan harian, dan berkomunikasi dengan
                    anggota kelompok PKL.
                    Pastikan seluruh aktivitas dicatat secara
                    teratur agar perkembangan PKL dapat dipantau.
                </p>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
