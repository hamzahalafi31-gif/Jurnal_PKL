
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Rekap Presensi
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4"
         style="border-radius:16px;background:linear-gradient(120deg,#155eef,#4388ff);color:white;">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-2">Rekap Presensi PKL</h3>
            <p class="mb-0">
                Kelola dan pantau kehadiran seluruh anggota PKL.
            </p>
        </div>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">

            <form action="<?= base_url('presensi/rekap') ?>"
                  method="get">

                <div class="row g-3 align-items-end">

                    <div class="col-md-5">
                        <label class="form-label fw-semibold">
                            Cari Nama Anggota
                        </label>

                        <input
                            type="text"
                            name="keyword"
                            class="form-control"
                            placeholder="Masukkan nama atau username..."
                            value="<?= esc($keyword ?? '') ?>"
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Filter Tanggal
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="<?= esc($tanggal ?? '') ?>"
                        >
                    </div>

                    <div class="col-md-3">
                        <button type="submit"
                                class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>
                            Cari Data
                        </button>

                        <a href="<?= base_url('presensi/rekap') ?>"
                           class="btn btn-light border">
                            Reset
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- Tabel Rekap -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Data Seluruh Presensi</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Foto Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Foto Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($rekap)): ?>

                            <?php $no = 1; ?>

                            <?php foreach ($rekap as $row): ?>

                                <tr>

                                    <td><?= $no++ ?></td>

                                    <td>
                                        <div class="fw-semibold">
                                            <?= esc($row['nama_anggota'] ?? 'Pengguna tidak ditemukan') ?>
                                        </div>

                                        <small class="text-muted">
                                            <?= esc($row['username_anggota'] ?? '-') ?>
                                        </small>
                                    </td>

                                    <td>
                                        <?= date('d-m-Y', strtotime($row['tanggal'])) ?>
                                    </td>

                                    <td>
                                        <?= esc($row['jam_masuk'] ?: '--:--') ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($row['foto_masuk'])): ?>

                                            <a
                                                href="<?= base_url('uploads/presensi/' . rawurlencode($row['foto_masuk'])) ?>"
                                                target="_blank"
                                                rel="noopener"
                                            >
                                                <img
                                                    src="<?= base_url('uploads/presensi/' . rawurlencode($row['foto_masuk'])) ?>"
                                                    alt="Foto Masuk"
                                                    style="width:65px;height:55px;object-fit:cover;border-radius:8px;"
                                                >
                                            </a>

                                        <?php else: ?>
                                            <span class="text-muted">Belum ada</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?= esc($row['jam_pulang'] ?: '--:--') ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($row['foto_pulang'])): ?>

                                            <a
                                                href="<?= base_url('uploads/presensi/' . rawurlencode($row['foto_pulang'])) ?>"
                                                target="_blank"
                                                rel="noopener"
                                            >
                                                <img
                                                    src="<?= base_url('uploads/presensi/' . rawurlencode($row['foto_pulang'])) ?>"
                                                    alt="Foto Pulang"
                                                    style="width:65px;height:55px;object-fit:cover;border-radius:8px;"
                                                >
                                            </a>

                                        <?php else: ?>
                                            <span class="text-muted">Belum ada</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <span class="badge bg-success">
                                            <?= esc(ucfirst($row['status'] ?? '-')) ?>
                                        </span>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="8"
                                    class="text-center text-muted py-4">
                                    Data presensi tidak ditemukan.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <div class="text-muted small mt-3">
                Total data ditemukan: <?= count($rekap ?? []) ?> presensi.
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
