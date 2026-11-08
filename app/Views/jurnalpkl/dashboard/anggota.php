<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Dashboard Anggota
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
/* Area dashboard */
.anggota-dashboard {
    animation: fadeIn 0.7s ease;
}

/* Animasi masuk */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Sambutan */
.welcome-card {
    position: relative;
    overflow: hidden;
    border-radius: 18px;
    padding: 30px;
    color: white;
    background: linear-gradient(120deg, #0756c9, #1687ff, #50b5ff);
    background-size: 200% 200%;
    animation: gradientMove 6s ease infinite;
    box-shadow: 0 8px 25px rgba(13, 110, 253, 0.18);
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.welcome-card h2 {
    font-weight: 700;
    margin-bottom: 10px;
}

/* Kartu menu */
.menu-card {
    height: 100%;
    min-height: 225px;
    padding: 23px;
    background: #fff;
    border: 1px solid #edf1f7;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    animation: fadeIn 0.8s ease both;
}

.menu-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 28px rgba(0, 80, 180, 0.12);
    border-color: #c7ddff;
}

.menu-icon {
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    font-size: 23px;
    margin-bottom: 18px;
}

.icon-blue {
    color: #0d6efd;
    background: #e8f1ff;
}

.icon-green {
    color: #159b68;
    background: #e5f8ef;
}

.icon-cyan {
    color: #08a6c5;
    background: #e4f9fc;
}

.icon-orange {
    color: #e99a00;
    background: #fff5df;
}

.menu-card h5 {
    font-weight: 700;
    color: #26364b;
    margin-bottom: 9px;
}

.menu-card p {
    color: #7b8798;
    font-size: 14px;
    line-height: 1.6;
    min-height: 43px;
}

.menu-button {
    border-radius: 8px;
    padding: 9px 16px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.25s ease;
}

.menu-button:hover {
    transform: translateX(4px);
}

/* Informasi */
.info-card {
    border: 0;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
}

/* Mengurangi animasi jika pengguna memilih reduced motion */
@media (prefers-reduced-motion: reduce) {
    .anggota-dashboard,
    .welcome-card,
    .menu-card {
        animation: none;
        transition: none;
    }
}
</style>

<div class="container-fluid anggota-dashboard">

    <!-- Sambutan -->
    <div class="welcome-card mb-4">
        <div class="position-relative">
            <span class="small font-weight-bold">
                SISTEM INFORMASI JURNAL PKL
            </span>

            <h2 class="mt-2">
                Selamat Datang,
                <?= esc(session()->get('nama')) ?>!
            </h2>

            <p class="mb-0">
                Selamat beraktivitas! Pantau presensi, tugas, dan
                jurnal kegiatan Praktik Kerja Lapangan kamu di sini.
            </p>
        </div>
    </div>

    <!-- Menu Utama -->
    <div class="d-flex align-items-center mb-3">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">
                Menu Utama
            </h5>
            <small class="text-muted">
                Akses fitur kegiatan PKL kamu
            </small>
        </div>
    </div>

    <div class="row">

        <!-- Presensi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="menu-card">
                <div class="menu-icon icon-blue">
                    <i class="bi bi-calendar-check"></i>
                </div>

                <h5>Presensi PKL</h5>
                <p>
                    Catat kehadiran dan kepulangan selama kegiatan PKL.
                </p>

                <a href="<?= base_url('presensi') ?>"
                   class="btn btn-primary menu-button">
                    Buka Presensi
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Task -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="menu-card">
                <div class="menu-icon icon-green">
                    <i class="bi bi-list-task"></i>
                </div>

                <h5>Task Management</h5>
                <p>
                    Lihat daftar tugas dan pantau pekerjaan PKL kamu.
                </p>

                <a href="<?= base_url('task') ?>"
                   class="btn btn-success menu-button">
                    Buka Task
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Jurnal -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="menu-card">
                <div class="menu-icon icon-cyan">
                    <i class="bi bi-journal-text"></i>
                </div>

                <h5>Jurnal Aktivitas</h5>
                <p>
                    Tulis dan dokumentasikan aktivitas harian PKL.
                </p>

                <a href="<?= base_url('jurnal') ?>"
                   class="btn btn-info text-white menu-button">
                    Buka Jurnal
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Chatroom -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="menu-card">
                <div class="menu-icon icon-orange">
                    <i class="bi bi-chat-dots"></i>
                </div>

                <h5>Chatroom</h5>
                <p>
                    Berkomunikasi dan bertukar informasi dengan pengguna.
                </p>

                <a href="<?= base_url('chat') ?>"
                   class="btn btn-warning text-white menu-button">
                    Buka Chat
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Informasi -->
    <div class="card info-card mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="menu-icon icon-blue mb-0 mr-3">
                    <i class="bi bi-info-circle"></i>
                </div>

                <div>
                    <h5 class="font-weight-bold mb-1">
                        Informasi PKL
                    </h5>
                    <p class="text-muted mb-0">
                        Jangan lupa mengisi presensi dan jurnal aktivitas
                        setiap hari selama melaksanakan Praktik Kerja Lapangan.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>