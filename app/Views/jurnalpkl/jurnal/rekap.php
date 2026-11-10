
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Rekap Jurnal Aktivitas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .rekap-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
    }

    .rekap-number {
        font-size: 28px;
        font-weight: 700;
    }

    .rekap-label {
        color: #6c757d;
        font-size: 14px;
    }

    @media print {
        .no-print,
        .sidebar,
        .navbar,
        footer {
            display: none !important;
        }

        .container-fluid {
            width: 100% !important;
            padding: 0 !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        body {
            background: white !important;
        }
    }
</style>

<div class="container-fluid">

    <!-- Judul halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="font-weight-bold">Rekap Jurnal Aktivitas</h4>
            <p class="text-muted mb-0">
                Ringkasan laporan kegiatan PKL.
            </p>
        </div>

        <div class="no-print">
            <a href="<?= base_url('jurnal') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Pesan error -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <!-- Kartu statistik -->
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card rekap-card border-left-primary">
                <div class="card-body">
                    <div class="rekap-label">Total Jurnal</div>
                    <div class="rekap-number text-primary">
                        <?= esc($rekap['total']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card rekap-card border-left-warning">
                <div class="card-body">
                    <div class="rekap-label">Menunggu</div>
                    <div class="rekap-number text-warning">
                        <?= esc($rekap['menunggu']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card rekap-card border-left-success">
                <div class="card-body">
                    <div class="rekap-label">Disetujui</div>
                    <div class="rekap-number text-success">
                        <?= esc($rekap['disetujui']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card rekap-card border-left-danger">
                <div class="card-body">
                    <div class="rekap-label">Ditolak</div>
                    <div class="rekap-number text-danger">
                        <?= esc($rekap['ditolak']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Filter tanggal -->
    <div class="card rekap-card mb-4 no-print">
        <div class="card-body">
            <h6 class="font-weight-bold mb-3">Filter Periode Jurnal</h6>

            <form action="<?= base_url('jurnal/rekap') ?>" method="get">
                <div class="row align-items-end">

                    <div class="col-md-4 mb-2">
                        <label>Tanggal Mulai</label>
                        <input
                            type="date"
                            name="tanggal_mulai"
                            class="form-control"
                            value="<?= esc($tanggalMulai ?? '') ?>"
                        >
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Tanggal Selesai</label>
                        <input
                            type="date"
                            name="tanggal_selesai"
                            class="form-control"
                            value="<?= esc($tanggalSelesai ?? '') ?>"
                        >
                    </div>

                    <div class="col-md-4 mb-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Terapkan Filter
                        </button>

                        <a href="<?= base_url('jurnal/rekap') ?>"
                           class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Tabel jurnal -->
    <div class="card rekap-card">
        <div class="card-header bg-white">
            <h6 class="font-weight-bold mb-0">Rincian Jurnal Aktivitas</h6>

            <small class="text-muted">
                Periode:
                <?= !empty($tanggalMulai) ? esc($tanggalMulai) : 'Semua tanggal' ?>
                sampai
                <?= !empty($tanggalSelesai) ? esc($tanggalSelesai) : 'Semua tanggal' ?>
            </small>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nama Anggota</th>
                            <th>Judul Kegiatan</th>
                            <th>Jam</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($rekap['data'])): ?>
                            <?php foreach ($rekap['data'] as $no => $item): ?>
                                <tr>
                                    <td><?= $no + 1 ?></td>

                                    <td>
                                        <?= esc($item['tanggal']) ?>
                                    </td>

                                    <td>
                                        <?= esc($item['nama_user'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= esc($item['judul_kegiatan']) ?>
                                    </td>

                                    <td>
                                        <?= esc($item['jam_mulai'] ?? '-') ?>
                                        -
                                        <?= esc($item['jam_selesai'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?php if ($item['status'] === 'menunggu'): ?>
                                            <span class="badge badge-warning">
                                                Menunggu
                                            </span>
                                        <?php elseif ($item['status'] === 'disetujui'): ?>
                                            <span class="badge badge-success">
                                                Disetujui
                                            </span>
                                        <?php elseif ($item['status'] === 'ditolak'): ?>
                                            <span class="badge badge-danger">
                                                Ditolak
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">
                                                <?= esc($item['status']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data jurnal pada periode ini.
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
