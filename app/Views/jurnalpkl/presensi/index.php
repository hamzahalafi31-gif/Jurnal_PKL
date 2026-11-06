
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Presensi PKL
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Notifikasi -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4"
         style="border-radius:16px;background:linear-gradient(120deg,#155eef,#4388ff);color:white;">

        <div class="card-body p-4">
            <h3 class="fw-bold mb-2">Presensi PKL</h3>
            <p class="mb-0">
                Selamat datang, <?= esc(session()->get('nama')) ?>.
                Silakan lakukan presensi harian kamu.
            </p>
        </div>
    </div>

    <!-- Informasi waktu -->
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Tanggal Hari Ini</small>
                    <h5 class="fw-bold mt-2">
                        <?= date('d-m-Y') ?>
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Jam Masuk</small>
                    <h5 class="fw-bold mt-2">
                        <?= !empty($presensiHariIni['jam_masuk'])
                            ? date('H:i', strtotime($presensiHariIni['jam_masuk']))
                            : '--:--' ?>
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Jam Pulang</small>
                    <h5 class="fw-bold mt-2">
                        <?= !empty($presensiHariIni['jam_pulang'])
                            ? date('H:i', strtotime($presensiHariIni['jam_pulang']))
                            : '--:--' ?>
                    </h5>
                </div>
            </div>
        </div>

    </div>

    <!-- Presensi Hari Ini -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">Presensi Hari Ini</h5>

            <?php if (!$presensiHariIni): ?>

                <p class="text-muted">
                    Kamu belum melakukan presensi masuk hari ini.
                </p>

                <form action="<?= base_url('presensi/store') ?>"
                      method="post"
                      enctype="multipart/form-data">

                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Foto Bukti Presensi Masuk
                        </label>

                        <input
                            type="file"
                            name="foto_masuk"
                            class="form-control"
                            accept="image/jpeg,image/png,image/webp"
                            capture="environment"
                            required
                        >

                        <small class="text-muted">
                            Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Presensi Masuk
                    </button>

                </form>

            <?php elseif (empty($presensiHariIni['jam_pulang'])): ?>

                <div class="alert alert-success">
                    Presensi masuk sudah tercatat.
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Foto Presensi Masuk
                    </label>
                    <?php if (!empty($presensiHariIni['foto_masuk'])): ?>
                        <div>
                            <img
                                src="<?= base_url('uploads/presensi/' . rawurlencode($presensiHariIni['foto_masuk'])) ?>"
                                alt="Foto Presensi Masuk"
                                style="width:150px;height:120px;object-fit:cover;border-radius:10px;"
                            >
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Foto tidak tersedia.</p>
                    <?php endif; ?>
                </div>

                <hr>

                <form action="<?= base_url('presensi/pulang') ?>"
                      method="post"
                      enctype="multipart/form-data">

                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Foto Bukti Presensi Pulang
                        </label>

                        <input
                            type="file"
                            name="foto_pulang"
                            class="form-control"
                            accept="image/jpeg,image/png,image/webp"
                            capture="environment"
                            required
                        >

                        <small class="text-muted">
                            Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-warning px-4">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Presensi Pulang
                    </button>

                </form>

            <?php else: ?>

                <div class="alert alert-primary">
                    Presensi hari ini sudah lengkap. Terima kasih!
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Foto Presensi Masuk
                        </label>

                        <?php if (!empty($presensiHariIni['foto_masuk'])): ?>
                            <div>
                                <img
                                    src="<?= base_url('uploads/presensi/' . rawurlencode($presensiHariIni['foto_masuk'])) ?>"
                                    alt="Foto Masuk"
                                    style="width:180px;height:140px;object-fit:cover;border-radius:10px;"
                                >
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Foto tidak tersedia.</p>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Foto Presensi Pulang
                        </label>

                        <?php if (!empty($presensiHariIni['foto_pulang'])): ?>
                            <div>
                                <img
                                    src="<?= base_url('uploads/presensi/' . rawurlencode($presensiHariIni['foto_pulang'])) ?>"
                                    alt="Foto Pulang"
                                    style="width:180px;height:140px;object-fit:cover;border-radius:10px;"
                                >
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Foto tidak tersedia.</p>
                        <?php endif; ?>
                    </div>

                </div>

            <?php endif; ?>

        </div>
    </div>

    <!-- Riwayat Presensi -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Riwayat Presensi</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Foto Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Foto Pulang</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($riwayat)): ?>

                            <?php $no = 1; ?>

                            <?php foreach ($riwayat as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>

                                    <td>
                                        <?= date('d-m-Y', strtotime($row['tanggal'])) ?>
                                    </td>

                                    <td>
                                        <?= esc($row['jam_masuk'] ?: '--:--') ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($row['foto_masuk'])): ?>
                                            <a href="<?= base_url('uploads/presensi/' . rawurlencode($row['foto_masuk'])) ?>"
                                               target="_blank">
                                                <img
                                                    src="<?= base_url('uploads/presensi/' . rawurlencode($row['foto_masuk'])) ?>"
                                                    alt="Foto Masuk"
                                                    style="width:65px;height:50px;object-fit:cover;border-radius:6px;"
                                                >
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?= esc($row['jam_pulang'] ?: '--:--') ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($row['foto_pulang'])): ?>
                                            <a href="<?= base_url('uploads/presensi/' . rawurlencode($row['foto_pulang'])) ?>"
                                               target="_blank">
                                                <img
                                                    src="<?= base_url('uploads/presensi/' . rawurlencode($row['foto_pulang'])) ?>"
                                                    alt="Foto Pulang"
                                                    style="width:65px;height:50px;object-fit:cover;border-radius:6px;"
                                                >
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <span class="badge bg-success">
                                            <?= esc(ucfirst($row['status'])) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= esc($row['keterangan'] ?? '-') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada riwayat presensi.
                                </td>
                            </tr>

                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
