
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Dashboard Admin
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .dashboard-wrapper {
        padding: 25px 0;
    }

    .welcome-card {
        padding: 30px;
        border-radius: 16px;
        color: white;
        background: linear-gradient(120deg, #2563eb, #1e40af);
        margin-bottom: 30px;
        box-shadow: 0 8px 25px rgba(37,99,235,.15);
    }

    .welcome-card h3 {
        font-weight: 700;
    }

    .welcome-card p {
        color: #dbeafe;
        margin-bottom: 0;
    }

    .section-heading {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e8eef8;
        border-radius: 14px;
        padding: 22px;
        height: 100%;
        box-shadow: 0 4px 15px rgba(15,23,42,.04);
        transition: .2s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(37,99,235,.10);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 15px;
    }

    .stat-card h3 {
        font-size: 27px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .stat-card p {
        color: #64748b;
        margin: 0;
        font-size: 14px;
    }

    .icon-blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .icon-purple {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .icon-green {
        background: #ecfdf5;
        color: #059669;
    }

    .icon-orange {
        background: #fff7ed;
        color: #ea580c;
    }

    .icon-cyan {
        background: #ecfeff;
        color: #0891b2;
    }

    .management-card {
        background: white;
        border: 1px solid #e8eef8;
        border-radius: 14px;
        padding: 22px;
        height: 100%;
    }

    .management-card h5 {
        color: #1e293b;
        font-weight: 700;
    }

    .management-card p {
        color: #64748b;
        font-size: 13px;
        min-height: 40px;
    }

    .management-button {
        display: inline-block;
        padding: 9px 15px;
        border-radius: 8px;
        color: #2563eb;
        background: #eff6ff;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .management-button:hover {
        color: white;
        background: #2563eb;
    }
    .stat-link {
    display: block;
    text-decoration: none;
    color: inherit;
    }

    .stat-link .stat-card {
    height: 100%;
    cursor: pointer;
    transition: all 0.3s ease;
    }

    .stat-link:hover .stat-card {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.10);
    }
</style>

<div class="container-fluid dashboard-wrapper">

    <!-- Sambutan -->
    <div class="welcome-card">
        <div class="mb-2 small text-white">
            SISTEM INFORMASI PRAKTIK KERJA LAPANGAN
        </div>

        <h3>
            Selamat Datang, <?= esc(session()->get('nama')) ?>!
        </h3>

        <p>
            Anda login sebagai Administrator.
            Kelola dan pantau seluruh kegiatan PKL melalui dashboard ini.
        </p>
    </div>

    <!-- Statistik Pengguna -->
    <h5 class="section-heading">Statistik Pengguna</h5>

    <div class="row g-3 mb-4">

    <div class="col-xl-4 col-md-6">
        <a href="<?= base_url('manajemen-pengguna') ?>"
           class="stat-link">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h3><?= esc($totalPengguna) ?></h3>
                <p>Total Pengguna</p>
            </div>
        </a>
    </div>

    <div class="col-xl-2 col-md-6">
        <a href="<?= base_url('manajemen-pengguna?role=admin') ?>"
           class="stat-link">
            <div class="stat-card">
                <div class="stat-icon icon-purple">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3><?= esc($totalAdmin) ?></h3>
                <p>Administrator</p>
            </div>
        </a>
    </div>

    <div class="col-xl-2 col-md-6">
        <a href="<?= base_url('manajemen-pengguna?role=petugas') ?>"
           class="stat-link">
            <div class="stat-card">
                <div class="stat-icon icon-orange">
                    <i class="bi bi-person-gear"></i>
                </div>
                <h3><?= esc($totalPetugas) ?></h3>
                <p>Petugas</p>
            </div>
        </a>
    </div>

    <div class="col-xl-2 col-md-6">
        <a href="<?= base_url('manajemen-pengguna?role=anggota') ?>"
           class="stat-link">
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class="bi bi-mortarboard"></i>
                </div>
                <h3><?= esc($totalAnggota) ?></h3>
                <p>Anggota</p>
            </div>
        </a>
    </div>

    <div class="col-xl-2 col-md-6">
        <a href="<?= base_url('manajemen-pengguna?role=pembimbing') ?>"
           class="stat-link">
            <div class="stat-card">
                <div class="stat-icon icon-cyan">
                    <i class="bi bi-person-check"></i>
                </div>
                <h3><?= esc($totalPembimbing) ?></h3>
                <p>Pembimbing</p>
            </div>
        </a>
    </div>

</div>

    <!-- Manajemen Data -->
    <h5 class="section-heading">Manajemen Data</h5>

    <div class="row g-3">

        <div class="col-xl-3 col-md-6">
            <div class="management-card">
                <div class="stat-icon icon-blue">
                    <i class="bi bi-people"></i>
                </div>
                <h5>Data Pengguna</h5>
                <p>Kelola akun dan hak akses seluruh pengguna.</p>
                <a href="<?= base_url('manajemen-pengguna') ?>"
                   class="management-button">
                    Kelola Pengguna
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="management-card">
                <div class="stat-icon icon-green">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h5>Presensi PKL</h5>
                <p>Pantau rekap kehadiran peserta PKL.</p>
                <a href="<?= base_url('presensi/rekap') ?>"
                   class="management-button">
                    Lihat Presensi
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="management-card">
                <div class="stat-icon icon-orange">
                    <i class="bi bi-journal-text"></i>
                </div>
                <h5>Jurnal Aktivitas</h5>
                <p>Pantau dokumentasi aktivitas harian PKL.</p>
                <a href="<?= base_url('jurnal') ?>"
                   class="management-button">
                    Lihat Jurnal
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="management-card">
                <div class="stat-icon icon-purple">
                    <i class="bi bi-list-task"></i>
                </div>
                <h5>Task Management</h5>
                <p>Pantau tugas dan pekerjaan peserta PKL.</p>
                <a href="<?= base_url('task') ?>"
                   class="management-button">
                    Lihat Tugas
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
