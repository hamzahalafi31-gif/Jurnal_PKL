
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Dashboard Jurnal PKL
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <div class="mb-4">
        <h3 class="fw-bold">Dashboard Jurnal PKL</h3>
        <p class="text-muted">
            Selamat datang, <?= esc(session()->get('nama')) ?>!
            Semoga kegiatan PKL hari ini berjalan lancar.
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-primary mb-3">
                        <i class="bi bi-calendar-check fs-1"></i>
                    </div>
                    <h6 class="text-muted">Presensi</h6>
                    <h5 class="fw-bold">Kehadiran PKL</h5>
                    <a href="<?= base_url('presensi') ?>"
                       class="btn btn-primary btn-sm mt-2">
                        Buka Presensi
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-success mb-3">
                        <i class="bi bi-list-task fs-1"></i>
                    </div>
                    <h6 class="text-muted">Task Management</h6>
                    <h5 class="fw-bold">Daftar Tugas</h5>
                    <a href="<?= base_url('task') ?>"
                       class="btn btn-success btn-sm mt-2">
                        Buka Tugas
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-warning mb-3">
                        <i class="bi bi-journal-text fs-1"></i>
                    </div>
                    <h6 class="text-muted">Jurnal Aktivitas</h6>
                    <h5 class="fw-bold">Catatan Kegiatan PKL</h5>
                    <a href="<?= base_url('jurnal') ?>"
                       class="btn btn-warning btn-sm mt-2">
                        Buka Jurnal
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-info mb-3">
                        <i class="bi bi-chat-dots fs-1"></i>
                    </div>
                    <h6 class="text-muted">Chatroom</h6>
                    <h5 class="fw-bold">Diskusi Kelompok</h5>
                    <a href="<?= base_url('chat') ?>"
                       class="btn btn-info btn-sm mt-2">
                        Buka Chat
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h5 class="fw-bold">Informasi</h5>
            <p class="text-muted mb-0">
                Gunakan aplikasi ini untuk mencatat kehadiran,
                mengelola tugas, mendokumentasikan kegiatan harian,
                dan berkomunikasi dengan anggota kelompok PKL.
            </p>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
